<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return User::paginate();
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $user;
    }

    public function store()
    {
        $validated = $this->validateFormData();

        $user = User::create($validated);

        $token = $user->createToken('api_token');

        return ['token' => $token->plainTextToken];
    }

    public function update(User $user)
    {
        $this->authorize('update', $user);

        $validated = $this->validateFormData();

        $user->update($validated);

        return ['message' => "O usuário #{$user->id} foi atualizado com sucesso."];
    }

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
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    }
}
