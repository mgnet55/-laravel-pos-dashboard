<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required|array|min:1|max:2',
            'email' => 'required|email|unique:clients',
            'address' => 'required'
        ];
    }
}
