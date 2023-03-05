<?php

namespace App\Http\Controllers;

use App\Http\Requests\{TodoTaskStoreRequest, TodoTaskUpdateRequest};
use App\Http\Resources\TaskResource;
use App\Models\{Todo, Task};
use Illuminate\Auth\Access\AuthorizationException;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Todo $todo, TodoTaskStoreRequest $request): TaskResource
    {
        $this->authorize('store', $todo);
        $input = $request->validated();
        $todoTask = $todo->tasks()->create($input);

        return new TaskResource($todoTask);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Todo $todo, Task $task, TodoTaskUpdateRequest $request): TaskResource
    {
        $this->authorize('update', $task);
        $input = $request->validated();
        $task->update($input);

        return new TaskResource($task);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Todo $todo, Task $task): void
    {
        $this->authorize('destroy', $task);
        $task->delete();
    }
}
