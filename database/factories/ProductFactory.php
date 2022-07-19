<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [

            'name' => [
                'ar' => fake('ar_SA')->sentence(3),
                'en' => fake()->sentence(3),
            ],
            'description' => [
                'ar' => fake('ar_SA')->sentence(10),
                'en' => fake()->sentence(10),
            ],
            'purchase_price' => fake()->randomFloat(2, 5, 100),
            'sell_price' => fake()->randomFloat(2, 101, 250),
            'stock' => fake()->numberBetween(5, 150),
            'category_id' => fake()->randomElement([1, 2]),
        ];
    }
}
