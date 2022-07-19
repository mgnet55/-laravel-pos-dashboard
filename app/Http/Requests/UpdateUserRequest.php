<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'alpha',
            'last_name' => 'alpha',
            'password' => [Password::min(8)->letters()->numbers(), 'confirmed'],
            'email' => ['email', Rule::unique('users')->ignore($this->user)],
            'permissions' => 'array',
            'permissions.*' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',

        ];
    }
}
