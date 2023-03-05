<?php

namespace App\Services;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoService
{
    public function index(): AnonymousResourceCollection
    {
        $user = Todo::with('tasks')->paginate();
        return TodoResource::collection($user);
    }

    public function store($label)
    {

    }
}
