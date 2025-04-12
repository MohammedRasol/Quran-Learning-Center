<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function tableShow()
    {
        $students = Student::all();
        return view("studentView.studentsList", compact("students"));
    }

    public function addArchives(Student $student)
    {
        // $surahs=Surah::groubBy()->get();
        return view("studentView.addArchives", compact("student"));
    }

    public function archives(Student $student)
    {
        return view("studentView.studentsArchives", compact("student"));
    }

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
    public function show($id)
    {
        $student = Student::with("classroom")->where("id", $id)->first();
        return view("studentView.showStudent", compact("student"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $arr = explode("-", $student->birth_date);

        $student->birth_year = $arr[0];
        $student->birth_month = $arr[1];
        $student->birth_day = $arr[2];


        $arr = explode("-", $student->join_date);
        $student->join_year = $arr[0];
        $student->join_month = $arr[1];
        $student->join_day = $arr[2];
        $classrooms = Classroom::where("graduated", 0)->get();
        return view("studentView.editStudent", compact("student", "classrooms"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, $id)
    {

        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->family_name = $request->family_name;

        $student->phone = $request->phone;
        $student->birth_date = $request->birth_year . "-" . $request->birth_month . "-" . $request->birth_day;
        $student->join_date = $request->join_year . "-" . $request->join_month . "-" . $request->join_day;

        $student->email = $request->family_name;
        $student->classroom = $request->classroom;

        if ($request->has("image")) {
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $imagePath = $request->file("image")->store("images", "public");
            $student->image = $imagePath;
        }

        $res = $student->save();
        $classrooms = Classroom::where("graduated", 0)->get();
        return redirect("/student/$student->id")->with('success', 'تم حفظ معلومات الطالب');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
