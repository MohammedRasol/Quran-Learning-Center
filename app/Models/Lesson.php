<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = "lessons";
    protected $fillable = [
        "id",
        "topic",
        "user_id",
        "classroom_id",
        "started_at",
        "finished_at"
    ];
    public function classroom()
    {
        return $this->belongsTo(Classroom::class,"classroom_id");
    }
}
