<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class ProductExistWithQuantityUpdate implements InvokableRule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

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
        $order = request()->route('order')->load('products');
        //dd($this->data, $order);

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
