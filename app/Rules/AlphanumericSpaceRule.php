<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class AlphanumericSpaceRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match('/^[^-\s\pN][\pL\pM\pN\s_-]+$/u', $value)) {
            $fail('The :attribute must be letters,numbers and space.');
        }
    }
}
