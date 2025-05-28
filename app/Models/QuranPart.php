<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranPart extends Model
{
    protected  $table = "quran_parts";
    protected  $fillable = ["name", "surah_id", "part", "verses_in_part", "total_verses", "total_verses_in_part", "percentage"];

    function surah()
    {
        return $this->belongsTo(Surah::class, "surah_id", "id");
    }
    function getPartSurahs($partNo)
    {
        return Surah::select('id', 'name')
            ->whereIn('id', QuranPart::where('part', $partNo)->pluck('surah_id'))
            ->get();
    }
}
