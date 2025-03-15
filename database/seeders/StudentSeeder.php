<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ["name"=>"محمد","last_name"=>"رسول","family_name"=>"شطناوي","phone"=>"+962791234567","birth_date"=>"2000-01-01","join_date"=>"2025-01-01",],
            ["name"=>"اسامة","last_name"=>"ابراهيم","family_name"=>"عبابنه","phone"=>"+962791234567","birth_date"=>"2002-01-01","join_date"=>"2022-01-01",],
        ];
        foreach ($roles as $key => $value) {
            Student::create($value);
        }
    }
}
