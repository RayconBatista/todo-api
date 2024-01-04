<?php

namespace App\Services;

use App\Events\ForgotPassword;
use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\ResetPasswordTokenInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * @throws LoginInvalidException
     */
    public function login(string $email, string $password): array
    {
        $login = [
            'email' => $email,
            'password' => $password
        ];

        if (!$token = auth()->attempt($login))
        {
            throw new LoginInvalidException();
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    /**
     * @throws UserHasBeenTakenException()
     */
    public function register($data)
    {
        $user = User::where('email', $data['email'])->exists();

        if (!empty($user))
        {
            throw new UserHasBeenTakenException();
        }

        $userPassword = Hash::make($data['password']);

        $user = User::create([
            'first_name'            => $data['first_name'],
            'last_name'             => $data['last_name'],
            'email'                 => $data['email'],
            'password'              => $userPassword,
            'confirmation_token'    => Str::random(60),
        ]);

        event(new UserRegistered($user));

        return $user;
    }

    /**
     * @throws VerifyEmailTokenInvalidException
     */
    public function verifyEmail(string $token)
    {
        $user = User::where('confirmation_token', $token)->first();
        if(empty($user))
        {
            throw new VerifyEmailTokenInvalidException();
        }

        $user->confirmation_token   = null;
        $user->email_verified_at    = now();
        $user->save();

        return $user;
    }

    public function forgotPassword(string $email): string
    {
        $user = User::whereEmail($email)->firstOrFail();
        $token = Str::random(60);

        $passwordReset = new PasswordReset();
        $passwordReset->email = $user->email;
        $passwordReset->token = $token;
        $passwordReset->save();

        event(new ForgotPassword($user, $token));
        return '';
    }

    /**
     * @throws ResetPasswordTokenInvalidException
     */
    public function resetPassword($data): string
    {
        $passReset = PasswordReset::whereEmail($data['email'])->where('token', $data['token'])->first();

        if(empty($passReset))
        {
            throw new ResetPasswordTokenInvalidException();
        }
        $user = User::whereEmail($data['email'])->firstOrFail();
        $user->password = bcrypt($data['password']);
        $user->save();

        PasswordReset::whereEmail($data['email'])->delete();
        return '';
    }
}
