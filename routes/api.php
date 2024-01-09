<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, InviteController, MeController, TodoController, TaskController, UserController, ProjectController};

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
    Route::post('verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::prefix('me')->group(function () {
        Route::resource('/', MeController::class);
        Route::put('/{user}/update', [MeController::class, 'update'])->middleware('auth:api');
    });

    Route::resource('users', UserController::class);
    
    Route::post('user/send-invite', [InviteController::class, 'generateInvite'])->middleware('auth:api');
    // Route::get('/accept-invite/{token}', [InviteController::class, 'acceptInvite'])->name('accept.invite');

    Route::resource('todos', TodoController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/add-member', [ProjectController::class, 'addMember']);
    Route::resource('todo/{todo}/tasks', TodoController::class)->middleware('auth:api');
    Route::post('todo/{todo}/tasks/{task}', [TaskController::class, 'done']);
});
