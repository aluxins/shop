<?php

namespace Database\Factories;

use App\Models\StorePages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StorePages>
 */
class StorePagesFactory extends Factory
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
            'url' => $this->faker->word(),
            'sort' => rand(1, 10),
            'title' => $this->faker->sentence(3),
            'body' => implode('<br />', $this->faker->paragraphs(5)),
        ];
    }
}
