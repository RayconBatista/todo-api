<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): AnonymousResourceCollection
    {
        return TodoResource::collection(auth()->user()->todos);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Todo $todo): TodoResource
    {
        $this->authorize('view', $todo);
        $todo->load('tasks');
        return new TodoResource($todo);
    }

    public function store(TodoStoreRequest $request): TodoResource
    {
        $input = $request->validated();
        $todo = auth()->user()?->todos()->create($input);

        return new TodoResource($todo);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Todo $todo, TodoUpdateRequest $request): TodoResource
    {
        $this->authorize('update', $todo);
        $input = $request->validated();
        $todo->update($input);
        return new TodoResource($todo->fresh());
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Todo $todo):void
    {
        $this->authorize('destroy', $todo);
        $todo->delete();
    }
}
