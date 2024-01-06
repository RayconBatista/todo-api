<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'first_name' => 'Raycon',
                'last_name' => 'Lima',
                'email' => 'raycon@gmail.com',
                'password' => bcrypt('123456789'),
            ],
            [
                'first_name' => 'Eloise',
                'last_name' => 'Lima',
                'email' => 'eloise@gmail.com',
                'password' => bcrypt('123456789'),
            ]
        ]);

//        User::factory(5)->create();
    }
}
