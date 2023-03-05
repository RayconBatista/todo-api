<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskService
{
    public function index(): AnonymousResourceCollection
    {
        $user = Task::paginate();
        return TaskResource::collection($user);
    }
}
