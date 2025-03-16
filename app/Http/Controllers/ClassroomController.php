<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRoomRequest;
use App\Models\Classroom;
use App\Models\Group;
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

    /**
     * Show the form for creating a new classroom.
     */
    public function create()
    {
        $groups = Group::where("graduated", 0)->get();
        return view('classroom.addClassRoom', compact('groups'));
    }

    /**
     * Store a newly created classroom in storage.
     */
    public function store(ClassRoomRequest $request)
    {
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('classrooms', 'public');
        }

        Classroom::create($request);

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom created successfully.');
    }

    /**
     * Display the specified classroom.
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
        $groups = Group::where("graduated", 0)->get();
        return view('classroom.showClassRoom', compact('classroom', "groups"));
    }

    /**
     * Show the form for editing the specified classroom.
     */
    public function edit(Classroom $classroom)
    {
        $groups = Group::all();
        return view('classrooms.edit', compact('classroom', 'groups'));
    }

    /**
     * Update the specified classroom in storage.
     */
    public function update(ClassRoomRequest $request, Classroom $classroom)
    {
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($classroom->image) {
                Storage::disk('public')->delete($classroom->image);
            }
            $classroom->image = $request->file('image')->store('images', 'public');
        }
        $classroom->name=$request->name;
        $classroom->group_id=$request->group_id;
        $classroom->save();
        return redirect("class-room/$classroom->id")->with('success', 'تم تحديث معلومات الغرفة الصفية بنجاح.');
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
