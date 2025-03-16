<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected  $table = "groups";
    protected  $fillable = ["name", "image", "graduated"];
    public function classroom()
    {
        return $this->hasMany(Classroom::class);
    }
}
