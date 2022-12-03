<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => 'required|uuid',
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc',
            'cpf' => 'required|string|min:11|max:11',
            'password' => ['sometimes', 'required', 'confirmed', Password::min(8)]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'uuid' => 'uuid',
            'name' => 'nome',
            'email' => 'email',
            'cpf' => 'cpf',
            'password' => 'senha',
        ];
    }
}
