<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function update(MeUpdateRequest $request): UserResource
    {
        $input = $request->validated();
        $user = (new UserService())->update(auth()?->user(), $input);
        return new UserResource($user);
    }
}
