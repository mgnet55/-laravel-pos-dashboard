<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\InvokableRule;

class ProductExistWithQuantity implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $products = Product::select(['id', 'stock'])->find(array_keys($value));
        if ($products->count() == count($value)) {
            $products->each(function ($product) use ($value, $fail) {
                if ($product->stock < $value[$product->id]) {
                    $fail('Unavailable :attribute stock');
                }
            });
        } else {
            $fail('Invalid :attribute');
        }
    }
}
