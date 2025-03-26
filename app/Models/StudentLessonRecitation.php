<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudentLessonRecitation extends Model
{
    protected $fillable = [
        'student_id',
        'lesson_id',
        'surah_id',
        'from_verse',
        'to_verse',
        'notes',
        'rate',
        'recitation_date',
    ];
    protected $table = "student_lesson_recitations";
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function surah()
    {
        return $this->hasOne(Surah::class, "id", "surah_id");
    }
    static function IsSurahInStudentRecitations($request)
    {
        $recitation = self::where("student_id", $request->student_id)
            ->where("lesson_id", $request->lesson_id)
            ->where("surah_id", $request->surah_id)
            ->firstOrFail();
        return $recitation != null ? true : false;
    }
    static function IsStudentHaveRecitation($surah_id, $student_id, $lesson_id)
    {
        $recitation = self::where("surah_id", $surah_id)
            ->where("student_id", $student_id)
            ->where("lesson_id", $lesson_id)
            ->firstOrFail();
        return $recitation != null ? true : false;
    }
}
