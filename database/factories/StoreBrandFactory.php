<?php

namespace Database\Factories;

use App\Models\StoreBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreBrand>
 */
class StoreBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->word()).' '.ucfirst($this->faker->bothify()),
        ];
    }
}
