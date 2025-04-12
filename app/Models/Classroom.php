<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = "classrooms";
    protected $fillable = [
        "id",
        "group_id",
        "user_id",
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
    function shaikh()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function students()
    {
        return $this->hasMany(Student::class,"class_room_id");
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
