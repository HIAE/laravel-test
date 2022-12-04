<?php

namespace App\Services\Users;

use App\Constants\UserRoles;
use App\Helpers\AuthScopes;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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

    public function get(): ?Authenticatable
    {
        return Auth::user();
    }

    /**
     * @throws Throwable
     */
    public function create(array $data): ?Model
    {
        $model = $this->userRepository->create($data);
        throw_if(!$model, \Exception::class);
        return $model;
    }

}
