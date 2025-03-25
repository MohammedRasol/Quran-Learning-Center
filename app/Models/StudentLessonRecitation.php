<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
