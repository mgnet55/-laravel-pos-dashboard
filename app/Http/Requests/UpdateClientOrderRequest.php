<?php

namespace App\Http\Requests;

use App\Rules\ProductExistWithQuantityUpdate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientOrderRequest extends FormRequest
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
            'products.*' => 'integer|min:1',
            'products' => [
                'bail',
                'required',
                'array',
                new ProductExistWithQuantityUpdate()
            ],

        ];
    }

    public function attributes()
    {
        return ['products.*' => 'product'];
    }
}
