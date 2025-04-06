<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAbsent extends Model
{
    protected $table = "students_absent";
    protected $fillable = ["student_id", "lesson_id", "absence_date", "reason"];
    function student()
    {
        return $this->belongsTo(Student::class, "id", "student_id");
    }
    function lesson()
    {
        return $this->belongsTo(Lesson::class, "id", "lesson_id");
    }

    static function addStudentAbsent($lesson_id, $student_id, $absence_date, $reason = "")
    {
        $studentAbsent = self::create([
            "lesson_id" => $lesson_id,
            "student_id" => $student_id,
            "absence_date" => $absence_date,
            "reason" => $reason,
        ]);
        return $studentAbsent;
    }
    static function getStudentAbsent($lesson_id, $student_id)
    {
        $studentAbsent = self::where("lesson_id", $lesson_id)->where("student_id", $student_id)->first();
        return $studentAbsent;
    }

    static function removeStudentAbsent($lesson_id, $student_id)
    {
        $studentAbsent = self::where("lesson_id", $lesson_id)->where("student_id", $student_id)->delete();
        return $studentAbsent;
    }
}
