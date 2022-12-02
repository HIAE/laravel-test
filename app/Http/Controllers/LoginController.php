<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * @lrd:start
     * Login user, create and return API token
     * @lrd:end
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response([
                'message' => 'As credenciais fornecidas não correspondem aos nossos registros',
            ], 401)
                ->header('Content-Type', 'text/plain');
        }

        $token = $this->userService->createApiToken($request->user());

        return ['token' => $token->plainTextToken];
    }
}
