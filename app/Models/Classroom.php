<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = "classrooms";
    protected $fillable = [
        "id",
        "group_id",
        "name",
        "nick_name",
        "start_date",
        "closed_date",
        "image",
        "graduated",
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
