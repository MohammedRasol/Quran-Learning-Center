<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeerder::class);
        User::factory()->create([
            "name" => "mohammed",
            "last_name" => "rasol",
            "family_name" => "shatnawi",
            "user_name" => "admin",
            "role" => 1,
            "email" => "admin@admin.admin",
            "password" => '$2y$12$Ljh/O7JP0j5ann66RPwt0.0HXKdrSLXNOfZMipNPcNS2cHW6FMWRG'
        ]);
        User::factory()->create([
            "name" => "احمد",
            "last_name" => "",
            "family_name" => "شطناوي",
            "user_name" => "shaikh_1",
            "role" => 2,
            "email" => "shaikh@shaikh.shaikh",
            "password" => '$2y$12$Ljh/O7JP0j5ann66RPwt0.0HXKdrSLXNOfZMipNPcNS2cHW6FMWRG'
        ]);
        $this->call(StudentSeeder::class);

    }
}
