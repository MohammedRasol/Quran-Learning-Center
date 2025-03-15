<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected  $table = "students";
    protected  $fillable = ["name", "last_name", "family_name", "phone", "user_name", "birth_date", "join_date", "image", "email"];
}
