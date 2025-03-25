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
            ->where('surahs.id', $surah_id) // Ensure we fetch the correct Surah
            ->select([
                'surahs.total_verses',
                \DB::raw('COALESCE(MIN(from_verse), 0) as min_from_verse'),
                \DB::raw('COALESCE(MAX(to_verse), 0) as max_to_verse')
            ])
            ->first();
        if ($data->total_verses - $data->max_to_verse == 0)
            $data->note = "تم تسميع السورة كاملة";
        else
            $data->note = "تبقى " . ($data->total_verses - $data->max_to_verse) . " ايه";
        return  $data;
    }
}
