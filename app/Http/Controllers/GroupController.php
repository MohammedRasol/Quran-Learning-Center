<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Expectation;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view("group.groupList", compact("groups"));
    }
    public function tableShow()
    {
        $groups = Group::all();
        return view("group.tableShow", compact("groups"));
    }
    public function create()
    {
        $classrooms = Classroom::where("graduated", 0)->where("group_id", null)->get();
        $shaikhs = User::where("role", 2)->doesntHave("classRoom")->doesntHave("group")->get();
        return view("group.addGroup", compact("classrooms", "shaikhs"));
    }
    public function store(GroupRequest $request)
    {
        try {
            $group = new Group();
            $group->name = $request->name;

            // Handle user_id assignment
            if ($request->filled('user_id')) {
                $shaikh = User::findOrFail($request->user_id); // Changed to findOrFail for better error handling
                if ($shaikh->classRoom) {
                    return redirect()
                        ->back()
                        ->withErrors(['user_id' => 'الشيخ مرتبط بغرفة صفية!'])
                        ->withInput();
                }
                $group->user_id = $request->user_id;
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Since this is a new group, no need to check for existing image
                $group->image = $request->file('image')->store('images', 'public');
            }

            $group->save();
            $this->assignClassRooms($request, $group);

            return redirect("group/{$group->id}")
                ->with('success', 'تم إضافة المجموعة بنجاح');
        } catch (\Exception $e) {  // Fixed Expectation typo
            \Log::error('Group creation failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => 'حدث خطأ أثناء إضافة المجموعة'])
                ->withInput();
        }
    }
    public function show($id)
    {

        $groupData = Group::findOrFail($id);

        // See the raw SQL
        $shaikhs = User::where("role", 2)
            ->Where(function ($query) use ($groupData) {
                $query->doesntHave("group")
                    ->orWhere("id", $groupData->user_id);
            })
            ->get();

        $classrooms = Classroom::where("graduated", 0)->where("group_id", null)->orWhere("group_id", $id)->get();
        $groupData->classroom = $groupData->classroom->pluck('id')->toArray(); // Convert to array of IDs
        return view("group.showGroup", compact("groupData", "classrooms", "shaikhs"));
    }
    function update(GroupRequest $req, $id)
    {
        try {
            $groupData = Group::findOrFail($id);
            $groupData->name = $req->name;

            if ($req->exists("user_id")) {
                $shaikh = User::findOrFail($req->user_id)->classRoom;
                if (!$shaikh)
                    $groupData->user_id = $req->user_id;
                else
                    return redirect()->back()->withErrors(['user_id' => 'الشيخ مرتبط بغرفة صفية !'])->withInput();
            }


            $groupData->user_id = $req->user_id ?? null;
            if ($req->has("image")) {
                if ($groupData->image) {
                    Storage::disk('public')->delete($groupData->image);
                }
                $imagePath = $req->file("image")->store("images", "public");
                $groupData->image = $imagePath;
            }
            $groupData->save();
            $this->assignClassRooms($req, $groupData);

            return redirect()->back()->with("success", "تم تحديث البيانات بنجاح !");
        } catch (Expectation $th) {

            return redirect()->back()->with("success", $th->getExceptionMessage());
        }
    }
    public function assignClassRooms(Request $request, $group)
    {
        $classroomIds = $request->input('class_rom_id'); // Array of classroom IDs
        Classroom::where('group_id', $group->id)->update(['group_id' => null]);
        if (($classroomIds)) {
            Classroom::whereIn('id', $classroomIds)->where("group_id", null)->update(['group_id' => $group->id]);
        }
    }
}
