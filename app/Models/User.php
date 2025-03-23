<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'family_name',
        'role',
        'user_name',
        'image',
        'password',
        'email'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    static function generateUniqueUsername($length = 3, $maxAttempts = 100)
    {
        $attempts = 0;
        do {
            $username = rand(1000, 9999);
            $attempts++;
            if ($attempts >= $maxAttempts) {
                throw new Exception('Unable to generate unique username');
            }
        } while (User::where('user_name', $username)->exists());

        return $username;
    }
    function classRoom()
    {
        return $this->hasOne(Classroom::class);
    }
    function group()
    {
        return $this->hasOne(Group::class);
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, "user_id", "id");
    }
    public function getFulleName()
    {
        return $this->name . " " . $this->last_name . " " . $this->family_name;
    }
}
