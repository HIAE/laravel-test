<?php

namespace App\Http\Requests\Idea;

use Illuminate\Foundation\Http\FormRequest;

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
            'idea' => 'required|string|max:255',
            'key_word' => 'required|string|max:20',
            'user_id' => 'required|exists:users,uuid',
            'category_id' => 'required|exists:categories,uuid',
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
            'idea' => 'idea',
            'user_id' => 'id do usuário',
            'category_id' => 'id da categoria',
            'key_word' => 'palavra chave',
        ];
    }
}
