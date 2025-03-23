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
}
