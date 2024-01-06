<?php

namespace App\Http\Controllers;

use App\Http\Requests\{TodoTaskStoreRequest, TodoTaskUpdateRequest};
use App\Http\Resources\TaskResource;
use App\Models\{Todo, Task};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index(): AnonymousResourceCollection
    {
        $todos = Task::latest()->paginate();
        // $todos = auth()->user()->todos()->latest()->paginate(15);
        return TaskResource::collection($todos);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Todo $todo, TodoTaskStoreRequest $request): TaskResource
    {
        // $this->authorize('store', $todo);
        $input = $request->validated();
        $todoTask = $todo->tasks()->create($input);

        return TaskResource::make($todoTask);
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

        if ($todo->tasks()->count() === 1) {
            // Se for a última tarefa, então pode excluir o todo
            $todo->delete();
        } else {
            // Se houver mais tarefas, apenas excluir a tarefa
            $task->delete();
        }
    }

    public function done(Todo $todo, Task $task): void
    {
        $task->is_completed = true;
        $task->update();
    }
}
