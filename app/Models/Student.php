<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\MockObject\Builder\Stub;

class Student extends Model
{
    protected  $table = "students";
    protected  $fillable = ["name", "last_name", "family_name", "phone", "user_name", "birth_date", "join_date", "image", "email", "classroom"];
    public function classroom()
    {
        return $this->hasMany(Classroom::class, "id", "classroom");
    }
    public function recitations()
    {
        return $this->hasMany(StudentLessonRecitation::class);
    }
    function absences()
    {
        return $this->hasMany(StudentAbsent::class, "student_id", "id");
    }
    public function getFullName()
    {
        return $this->name . " " . $this->last_name . " " . $this->family_name;
    }
    public function students()
    {
        return $this->hasMany(Student::class, "students_lessons", "student_id", "id");
    }
}
