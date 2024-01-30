<?php

namespace Database\Factories;

use App\Models\StoreSections;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreSections>
 */
class StoreSectionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->word()),
            'sort' => rand(1, 10),
            'parent' => rand(1, 10),
            'visible' => 1,
            'link' => 1,
        ];
    }
}
