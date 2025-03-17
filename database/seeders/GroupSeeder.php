<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "name" => "المجموعة العامة",
                "image" => "public\adminlte\dist\assets\img\AdminLTELogo.png"
            ]
        ];
        foreach ($roles as $key => $value) {
            Group::create(["name" => $value["name"], "image" => $value["image"]]);
        }
    }
}
