<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRoomRequest;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\User;
use Database\Seeders\ClassRoomSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the classrooms.
     */
    public function index()
    {
        $classrooms = Classroom::all();
        return view('classRoom.classRoomList', compact('classrooms'));
    }
    public function tableShow()
    {
        $classrooms = Classroom::all();
        return view('classRoom.classRoomTable', compact('classrooms'));
    }

    /**
     * Show the form for creating a new classroom.
     */
    public function create()
    {
        $groups = Group::where("graduated", 0)->doesntHave('classroom')->get();
        $shaikhs = User::doesntHave("classRoom")->where("role", 2)->get();
        return view('classroom.addClassRoom', compact('groups', "shaikhs"));
    }

    /**
     * Store a newly created classroom in storage.
     */
    public function store(ClassRoomRequest $request)
    {
        $classroom = new Classroom();
        if ($request->hasFile('image')) {
            $classroom->image = $request->file('image')->store('classrooms', 'public');
        }

        if ($request->exists("shaikh_id")) {
            $shaikh = User::findOrFail($request->shaikh_id)->classRoom;
            if (!$shaikh)
                $classroom->user_id = $request->shaikh_id;
            else
                return redirect()->back()->withErrors(['shaikh_id' => 'الشيخ مرتبط بغرفة صفية !'])->withInput();
        }

        $classroom->group_id = $request->group_id;

        $classroom->name = $request->name;
        $classroom->nick_name = $request->nick_name;
        $classroom->start_date = $request->start_date;
        $classroom->closed_date = $request->closed_date;
        $classroom->save();

        return redirect('class-room/' . $classroom->id)
            ->with('success', 'تم إضافة الغرفة الصفية بنجاح.');
    }

    /**
     * Display the specified classroom.
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
        $groups = Group::where("graduated", 0)->doesntHave('classroom')->orWhere('id', $classroom->group_id)->get();
        $shaikhs = User::where(function ($query) use ($classroom) {
            $query->doesntHave('classRoom')
                ->orWhere("id", $classroom->user_id);
        })->where("role", 2)->get();
        return view('classroom.showClassRoom', compact('classroom', "groups", "shaikhs"));
    }

    /**
     * Show the form for editing the specified classroom.
     */
    public function edit(Classroom $classroom)
    {
        $groups = Group::where("graduated", 0)->get();
        return view('classrooms.edit', compact('classroom', 'groups'));
    }

    /**
     * Update the specified classroom in storage.
     */
    public function update(ClassRoomRequest $request, $id)
    {
        $classroom = Classroom::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($classroom->image) {
                Storage::disk('public')->delete($classroom->image);
            }
            $classroom->image = $request->file('image')->store('images', 'public');
        }
        $classroom->name = $request->name;
        $classroom->nick_name = $request->nick_name;
        $classroom->group_id = $request->group_id;
        $classroom->user_id = $request->shaikh_id;
        $classroom->start_date = $request->start_date;
        $classroom->save();
        return redirect()->back()->with('success', 'تم تحديث معلومات الغرفة الصفية بنجاح.');
    }

    /**
     * Remove the specified classroom from storage.
     */
    public function destroy(Classroom $classroom)
    {
        if ($classroom->image) {
            Storage::disk('public')->delete($classroom->image);
        }

        $classroom->delete();

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom deleted successfully.');
    }
}
