<?php

namespace App\Http\Requests;

use App\Rules\AlphanumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateProductRequest extends FormRequest
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
        $locales = LaravelLocalization::getSupportedLanguagesKeys();
        $localesString = implode(',', $locales);

        $rules = [];
        foreach ($locales as $locale) {
            $rules['name.' . $locale] = ['bail', Rule::unique('products', 'name->' . $locale)->ignore($this->product), new AlphanumericSpaceRule()];
            $rules['description.' . $locale] = ['bail', Rule::unique('products', 'description->' . $locale)->ignore($this->product), new AlphanumericSpaceRule()];

        }
        return [
            'name' => ['array:' . $localesString, 'required_array_keys:' . $localesString],
            'description' => ['array:' . $localesString, 'required_array_keys:' . $localesString],
            'sell_price' => 'numeric',
            'purchase_price' => 'numeric',
            'stock' => 'numeric|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'category_id' => 'exists:categories,id',
            /*Merging Localized Rules*/
            ...$rules
        ];
    }
}
