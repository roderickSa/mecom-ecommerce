<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            #admin
            [
                "name" => "Admin",
                'username' => "admin",
                "email" => "admin@gmail.com",
                "password" => bcrypt("123"),
                "role" => "admin",
                "status" => "active",
            ],
            #vendor
            [
                "name" => "Vendor",
                'username' => "vendor",
                "email" => "vendor@gmail.com",
                "password" => bcrypt("123"),
                "role" => "vendor",
                "status" => "active",
            ],
            #user or customer
            [
                "name" => "User",
                'username' => "user",
                "email" => "user@gmail.com",
                "password" => bcrypt("123"),
                "role" => "user",
                "status" => "active",
            ],
        ]);
    }
}
