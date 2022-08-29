<?php

namespace App\Http\Requests;

use App\Rules\ProductExistWithQuantity;
use Illuminate\Foundation\Http\FormRequest;

class StoreClientOrderRequest extends FormRequest
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
                new ProductExistWithQuantity()
            ],

        ];
    }

    public function attributes()
    {
        return ['products.*' => 'product'];
    }
}
