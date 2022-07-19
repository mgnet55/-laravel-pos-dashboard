<?php

namespace App\Http\Requests;

use App\Rules\AlphanumericSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreCategoryRequest extends FormRequest
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
            $rules['name.' . $locale] = ['required', 'unique:categories,name->' . $locale, new AlphanumericSpaceRule()];

        }
        return [
            'name' => ['required', 'array:' . $localesString, 'required_array_keys:' . $localesString],
            ...$rules
        ];
    }
}
