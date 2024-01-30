<?php

namespace Database\Factories;

use App\Models\StoreProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreProduct>
 */
class StoreProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section' => rand(1, 10),
            'name' => ucfirst($this->faker->words(3, true)),
            'article' => $this->faker->bothify('???######'),
            'description' => $this->faker->paragraphs(3, true),
            'brand' => rand(1, 10),
            'price' => $this->faker->randomFloat(2, 5, 10000),
            'old_price' => rand(0, 1) ? $this->faker->randomFloat(2, 5, 10000) : 0.00,
            'available' => rand(0, 20),
            'visible' => 1,
        ];
    }
}
