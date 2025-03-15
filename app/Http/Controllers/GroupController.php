<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view("groups.groupList", compact("groups"));
    }
    public function create()
    {
        return view("groups.addGroup");
    }
    public function store(GroupRequest $request)
    {
        $group = new Group();
        $group->name = $request->name;
        if ($request->has("image")) {
            $imagePath = $request->file("image")->store("images", "public");
            $group->image = $imagePath;
        }
  
        $res = $group->save();
        return redirect()->back()->with("success", "Data Saved");
    }
}
