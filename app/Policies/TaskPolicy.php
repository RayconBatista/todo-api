<?php

namespace App\Policies;

use App\Models\{User, Task};

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function store(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }

    
    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }
}
