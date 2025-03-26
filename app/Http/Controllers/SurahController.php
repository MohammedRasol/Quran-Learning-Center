<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentLessonRecitation;
use App\Models\Surah;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    public function getSurahinfo($surah_id, $lesson_id, $student_id)
    {
        $surah = new Surah();
        $data = $surah->getSurahinfo($surah_id, $lesson_id, $student_id);
        return response()->json(["data" => $data], 200);
    }
    public function saveRecitations($surah_id, $lesson_id, $student_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $lesson->recitations()->create([
            'student_id' => $student_id,
            'surah_id' => $surah_id,
            'from_verse' => request('firstVerse'),
            'to_verse' => request('lastVerse'),
            'notes' => request('notes'),
            'rate' => request('rating'),
        ]);

        return response()->json(["data" => $lesson,"status"=>200], 200);
    }
}
