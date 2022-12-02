<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPhotoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'photo' => [
                'required',
                'image',
                'mimes:jpeg,png',
                Rule::dimensions()
                    ->maxWidth(600)
                    ->maxHeight(600),
            ],
        ];
    }
}
