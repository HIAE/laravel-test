<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @lrd:start
     * List users. Only for admins.
     * @lrd:end
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return User::paginate();
    }

    /**
     * @lrd:start
     * List users. Only for admins.
     * @lrd:end
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $user;
    }

    /**
     * @lrd:start
     * User registration restrict to company's domain.
     * @lrd:end
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('api_token');

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

        $user->update($request->validated());

        return ['message' => "O usuário #{$user->id} foi atualizado com sucesso."];
    }

    /**
     * @lrd:start
     * Delete user. Only for admins.
     * @lrd:end
     */
    public function delete(User $user)
    {
        $message = "O usuário #{$user->id} foi removido com sucesso.";

        $user->delete();

        return ['message' => $message];
    }
}
