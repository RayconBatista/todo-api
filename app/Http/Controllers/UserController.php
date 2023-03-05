<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api');
        $this->userService = $userService;
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->userService->index();
    }
}
