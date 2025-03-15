<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeerder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            "SUPER_ADMIN",
            "SHAIKH",
            "STUDENT",
        ];
        foreach ($roles as $key => $value) {
            Role::create(["name" => $value]);
        }
    }
}
