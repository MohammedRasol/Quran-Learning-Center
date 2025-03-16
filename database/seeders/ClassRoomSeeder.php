<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "name" => "الصف الاول",
                "image" => "public\adminlte\dist\assets\img\AdminLTELogo.png",
                "group_id" => 1,
            ]
        ];
        foreach ($roles as $key => $value) {
            Classroom::create(["name" => $value["name"], "image" => $value["image"], "group_id" => $value["group_id"]]);
        }
    }
}
