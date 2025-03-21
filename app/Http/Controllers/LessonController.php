<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 2)
            $shaikhs = [Auth::user()];
        else
            $shaikhs = User::where("role", 2)->get();

        $classrooms = Classroom::where("graduated", 0)->where("user_id", Auth::user()->id)->get();
        $groups = Group::where("graduated", 0)->where("user_id", Auth::user()->id)->get();
        return view("lessonView.addLesson", compact("shaikhs", "classrooms", "groups"));
    }
    public function create()
    {
        return view("lessonView.addLesson");
    }

    public function store(Request $req)
    {
        $lesson = new Lesson();
        $lesson->topic = $req->topic;
        $lesson->user_id = $req->user_id;
        $lesson->started_at = $req->started_at;
        $lesson->finished_at = $req->finished_at;
        $classrooms = Classroom::whereIn('id', $req->class_room)->get();
        $lesson->saveMany($classrooms);
        $lesson->save();
    }
}
