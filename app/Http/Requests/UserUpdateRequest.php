<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'ends_with:@company.com',
            ],
            'cpf' => [
                'nullable',
                new Cpf,
            ],
            'password' => [
                'nullable',
                Password::min(8)->uncompromised(),
            ],
        ];
    }
}
