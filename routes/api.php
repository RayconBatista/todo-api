<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, DashboardController, InviteController, MeController, TodoController, TaskController, UserController, ProjectController, StatusController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::prefix('me')->group(function () {
        Route::resource('/', MeController::class);
        Route::put('/{user}/update', [MeController::class, 'update'])->middleware('auth:api');
    });

    Route::resource('users', UserController::class);
    
    Route::get('dashboard/tasks', [DashboardController::class, 'tasks']);
    Route::get('invites', [InviteController::class, 'index']);
    Route::post('user/send-invite', [InviteController::class, 'generateInvite']);

    Route::apiResource('status', StatusController::class);
    Route::resource('todos', TodoController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/add-member', [ProjectController::class, 'addMember']);

    Route::apiResource('todo/{todo}/tasks', TaskController::class);
    Route::post('tasks/{task}', [TaskController::class, 'changeStatus'])->name('tasks.changeStatus');
    Route::post('todos/{todo}/task/{task}', [TaskController::class, 'done'])->name('tasks.done');
    
});
