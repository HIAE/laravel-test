<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * List users. Only for admins.
     * @lrd:end
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return $this->service->getAllUsers();
    }

    /**
     * @lrd:start
     * List users. Only for admins.
     * @lrd:end
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $this->service->showUser($user);
    }

    /**
     * @lrd:start
     * User registration restrict to company's domain.
     * @lrd:end
     */
    public function store(UserRequest $request)
    {
        $token = $this->service->createUser($request);

        return ['token' => $token->plainTextToken];
    }

    /**
     * @lrd:start
     * Update users. Admins can update everyone, others only themselves.
     * @lrd:end
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $this->service->updateUser($user, $request);

        return ['message' => "O usuário #{$user->id} foi atualizado com sucesso."];
    }

    /**
     * @lrd:start
     * Delete user. Only for admins.
     * @lrd:end
     */
    public function delete(User $user)
    {
        $this->service->destroyUser($user);

        return ['message' => "O usuário #{$user->id} foi removido com sucesso."];
    }
}
