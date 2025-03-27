<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected  $table = "surahs";
    protected  $fillable = ["name", "total_verses"];

    function parts()
    {
        return $this->hasMany(QuranPart::class, "surah_id", "id");
    }

    public function getSurahinfo($surah_id, $lesson_id, $student_id)
    {
        $data = $this::leftJoin('student_lesson_recitations', function ($join) use ($student_id, $lesson_id, $surah_id) {
            $join->on('student_lesson_recitations.surah_id', '=', 'surahs.id')
                ->where('student_lesson_recitations.student_id', $student_id)
                ->where('student_lesson_recitations.lesson_id', $lesson_id)
                ->where('student_lesson_recitations.surah_id', $surah_id);
        })
            ->where('surahs.id', $surah_id)
            ->select([
                'surahs.total_verses',
                'student_lesson_recitations.from_verse',
                'student_lesson_recitations.to_verse',
                'student_lesson_recitations.id',
                'student_lesson_recitations.student_id',
                'student_lesson_recitations.lesson_id',
                'student_lesson_recitations.surah_id'
            ])
            ->orderBy('student_lesson_recitations.from_verse')
            ->get();

        // Calculate min and max in PHP
        $min_from_verse = $data->min('from_verse') ?? 0;
        $max_to_verse = $data->max('to_verse') ?? 0;

        // Attach to the data if needed
        $data->min_from_verse = $min_from_verse;
        $data->max_to_verse = $max_to_verse;
        return $data;


        if ($data->min_from_verse == 1 &&  $data->max_to_verse == $data->total_verses)
            $data->note = "تم تسميع السورة كاملة";
        else
            $data->note = "تبقى " . ($data->total_verses - ($data->max_to_verse - ($data->min_from_verse - 1))) . " ايه";
        return  $data;
    }
}
