<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

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
