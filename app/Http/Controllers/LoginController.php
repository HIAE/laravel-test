<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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

        $request->user()->tokens()->delete();

        $token = $request->user()->createToken('api_token');

        return ['token' => $token->plainTextToken];
    }
}
