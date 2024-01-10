<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginInvalidException;
use App\Exceptions\ResetPasswordTokenInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Models\Invite;
use App\Services\AuthService;
use Carbon\Carbon;

class AuthController extends Controller
{
    private AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws LoginInvalidException
     */
    public function login(AuthLoginRequest $request): UserResource
    {
        $input = $request->validated();
        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    /**
     * @throws UserHasBeenTakenException
     */
    public function register(AuthRegisterRequest $request)
    {
        $data = $request->validated();
        $user = $this->authService->register($data);
        $invite = Invite::where('email', $user->email)->first();
        $invite->registered_at = Carbon::now();
        $invite->is_used = true;
        $invite->update();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Projeto excluído com sucesso'
        ]);
    }

    /**
     * @throws VerifyEmailTokenInvalidException
     */
    public function verifyEmail(AuthVerifyEmailRequest $request)
    {
        $input = $request->validated();
        $user = $this->authService->verifyEmail($input['token']);
        $redirectUrl = 'http://localhost:5173/login';

        return redirect($redirectUrl);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request): void
    {
        $input = $request->validated();
        $this->authService->forgotPassword($input['email']);
    }

    /**
     * @throws ResetPasswordTokenInvalidException
     */
    public function resetPassword(AuthResetPasswordRequest $request): void
    {
        $data = $request->validated();
        $this->authService->resetPassword($data);
    }
}
