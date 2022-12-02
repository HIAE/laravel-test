<?php

namespace App\Services;

class UserService
{
    public function createApiToken()
    {
        request()->user()->tokens()->delete();

        $token = request()->user()->createToken('api_token');

        return $token;
    }
}
