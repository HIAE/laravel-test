<?php

namespace App\Services\Users;

use App\Constants\UserRoles;
use App\Helpers\AuthScopes;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserService
{

    /**
     * @throws Exception
     */
    public function authenticate(array $credentials)
    {
        if(Auth::attempt($credentials)){
            $user = Auth::user();

            if($user->role === UserRoles::EMPLOYER) {
                return $user->createToken('JWT', AuthScopes::getEmployerScopesToAbilities())->plainTextToken;
            }
            return $user->createToken('JWT', AuthScopes::getAdminScopesToAbilities())->plainTextToken;
        }
        throw new Exception();
    }

}
