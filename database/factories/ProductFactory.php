<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $name = $description = [];
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $name[$locale] = fake()->words(3, true);
            $description[$locale] = fake()->sentence(10);
        }

        return [

            'name' => $name,
            'description' => $description,
            'purchase_price' => fake()->randomFloat(2, 5, 100),
            'sell_price' => fake()->randomFloat(2, 101, 250),
            'stock' => fake()->numberBetween(5, 150),
            'category_id' => fake()->randomElement([1, 2]),
        ];
    }
}
