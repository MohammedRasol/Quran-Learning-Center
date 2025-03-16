<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view("group.groupList", compact("groups"));
    }
    public function create()
    {
        return view("group.addGroup");
    }
    public function store(GroupRequest $request)
    {
        $group = new Group();
        $group->name = $request->name;
        if ($group->image) {
            Storage::disk('public')->delete($group->image);
        }
        if ($request->has("image")) {
            $group->image = $request->file("image")->store("images", "public");
        }

        $group->save();
        return redirect("group/$group->id")->with("success", "تم إضافة المجموعة بنجاح");
    }
    public function show($id)
    {
        $groupData = Group::findOrFail($id);
        return view("group.showGroup", compact("groupData"));
    }
    function update(GroupRequest $req, $id)
    {
        $groupData = Group::findOrFail($id);
        $groupData->name = $req->name;
        if ($req->has("image")) {
            $imagePath = $req->file("image")->store("images", "public");
            $groupData->image = $imagePath;
        }
        $groupData->save();
        return redirect()->back()->with("success", "تم تحديث البيانات بنجاح !");
    }
}
