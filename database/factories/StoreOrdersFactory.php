<?php

namespace Database\Factories;

use App\Models\StoreOrders;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreOrders>
 */
class StoreOrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user' => rand(1, 10),
            'status' => rand(1, 6),
            ];
    }
}
