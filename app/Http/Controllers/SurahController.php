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
}
