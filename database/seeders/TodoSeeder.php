<?php

namespace Database\Seeders;

use App\Models\{User, Todo, Task};
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            $user->todos()->createMany(
                Todo::factory(10)->make()->toArray()
            )->each(function (Todo $todo) {
                $todo->tasks()->createMany(
                    Task::factory(3)->make()->toArray()
                );
            });
        });
    }
}
