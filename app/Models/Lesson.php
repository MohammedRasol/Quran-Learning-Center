<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = "lessons";
    protected $fillable = [
        "id",
        "topic",
        "user_id",
        "started_at",
        "finished_at"
    ];
    public function shaikh()
    {
        return $this->hasOne(User::class,"id","user_id");
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, "classrooms_lessons", "lesson_id", "classroom_id");
    }
    public function students()
    {
        return $this->belongsToMany(Classroom::class, "students_lessons", "lesson_id", "student_id");
    }
    public function recitations()
    {
        return $this->hasMany(StudentLessonRecitation::class);
    }
    function arabicDateTranslator($date)
    {
        return  Carbon::parse($date)->locale('ar')->translatedFormat('l d-m ');
    }
}
