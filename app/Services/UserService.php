<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function createApiToken(User $user, $token_name = 'api_token')
    {
        $user->tokens()->delete();

        return $user->createToken($token_name);
    }

    public function createUser(UserRequest $request)
    {
        $user = User::create($request->validated());

        return $this->createApiToken($user);
    }

    public function destroyUser(User $user): bool
    {
        return $user->delete();
    }

    public function getAllUsers()
    {
        return UserResource::collection(User::paginate());
    }

    public function showUser(User $user)
    {
        return new UserResource($user);
    }

    public function updateUser(User $user, UserRequest $request): bool
    {
        return $user->update($request->validated());
    }
}
