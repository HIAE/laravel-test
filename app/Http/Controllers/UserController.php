<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rules\Password;

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
    public function store()
    {
        $validated = $this->validateFormData();

        $user = User::create($validated);

        $token = $user->createToken('api_token');

        return ['token' => $token->plainTextToken];
    }

    /**
     * @lrd:start
     * Update users. Admins can update everyone, others only themselves.
     * @lrd:end
     */
    public function update(User $user)
    {
        $this->authorize('update', $user);

        $validated = $this->validateFormData();

        $user->update($validated);

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

    private function validateFormData(): array
    {
        return request()->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'ends_with:@company.com',
            ],
            'password' => [
                'required',
                Password::min(8)->uncompromised(),
            ],
        ]);
    }
}
