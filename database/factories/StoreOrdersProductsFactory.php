<?php

namespace Database\Factories;

use App\Models\StoreOrdersProducts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreOrdersProducts>
 */
class StoreOrdersProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order' => rand(1, 10),
            'product' => rand(1, 10),
            'quantity' => rand(1, 10),
            'price' => $this->faker->randomFloat(2, 5, 10000),
        ];
    }
}
