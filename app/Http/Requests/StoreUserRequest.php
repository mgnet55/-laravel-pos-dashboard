<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'password' => ['required', Password::min(8)->letters()->numbers(), 'confirmed'],
            'email' => 'required|email|unique:users,email',
            'permissions' => 'array',
            'permissions.*' => 'string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',

        ];
    }
}
