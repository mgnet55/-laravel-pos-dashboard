<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = [];
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $name[$locale] = fake()->words(4, true);
        }
        return [
            'name' => $name
        ];
    }
}
