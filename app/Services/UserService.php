<?php

namespace App\Services;

use App\Exceptions\UserHasBeenTakenException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserService
{
    public function index(): AnonymousResourceCollection
    {
        $user = User::with('todos')->paginate();
        return UserResource::collection($user);
    }

    /**
     * @throws UserHasBeenTakenException
     */
    public function update(User $user, array $input): ?User
    {
        if(!empty($input['email']) && User::whereEmail($input['email'])->exists())
        {
            throw new UserHasBeenTakenException();
        }

        if(!empty($input['password']))
        {
            $input['password'] = bcrypt($input['password']);
        }
        $user->fill($input);
        $user->save();
        return $user->fresh();
    }
}
