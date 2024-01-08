<?php

namespace Database\Seeders;

use App\Models\{Project, User, Todo, Task};
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            $this->createTodoList($user);
        });
    }

    /**
     * Create a Todo List for the given user.
     *
     * @param User $user
     */
    private function createTodoList(User $user): void
    {
        $project = $user->projects()->create([
            'name'        => 'Todo List',
            'description' => 'Projeto completo de todo list',
            'active'      => true,
        ]);

        $this->createTodosAndTasks($project, $user);
    }

    /**
     * Create Todos and associated Tasks for the given project.
     *
     * @param Project $project
     */
    private function createTodosAndTasks(Project $project, $user): void
    {
        $project->todos()->createMany(
            Todo::factory(2)->make(['user_id' => $user->id])->toArray()
        )->each(function (Todo $todo) {
            $todo->tasks()->createMany(
                Task::factory(3)->make()->toArray()
            );
        });
    }
}
