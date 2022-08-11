<?php

namespace App\Http\Requests;

use App\Models\Product;
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
                function ($attribute, $value, $fail) {
                    $products = Product::select(['id', 'stock'])->find(array_keys($value));
                    if ($products->count() == count(array_keys($value))) {
                        $products->each(function ($product) use ($value, $fail) {
                            if ($product->stock < $value[$product->id]) {
                                $fail('Unavailable :attribute stock');
                            }
                        });
                    } else {
                        $fail('Invalid :attribute');
                    }
                }
            ],

        ];
    }

    public function attributes()
    {
        return ['products.*' => 'product'];
    }
}
