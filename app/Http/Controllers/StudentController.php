<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view("studentView.studentsList", compact("students"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("studentView.addStudent");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->family_name = $request->family_name;

        $student->phone = $request->phone;
        $student->birth_date = $request->birth_year . "-" . $request->birth_month . "-" . $request->birth_day;
        $student->join_date = $request->join_year . "-" . $request->join_month . "-" . $request->join_day;

        $student->email = $request->family_name;

        if ($request->has("image")) {
            $imagePath = $request->file("image")->store("images", "public");
            $student->image = $imagePath;
        }
  
        $res = $student->save();
        return redirect()->back()->with("success", "Data Saved");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
