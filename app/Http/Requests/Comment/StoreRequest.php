<?php

namespace App\Http\Requests\Comment;

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
            'commentary' => 'required|string|max:255',
            'user_id' => 'required|exists:users,uuid',
            'idea_id' => 'required|exists:ideas,uuid',
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
            'commentary' => 'comentário',
            'user_id' => 'id do usuário',
            'idea_id' => 'id da ideia',
        ];
    }
}
