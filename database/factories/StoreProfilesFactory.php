<?php

namespace Database\Factories;

use App\Models\StoreProfiles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreProfiles>
 */
class StoreProfilesFactory extends Factory
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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'patronymic' => $this->faker->lastName(),
            'city' => $this->faker->city(),
            'street_address' => $this->faker->streetAddress(),
            'telephone' => $this->faker->e164PhoneNumber(),
            'about' => $this->faker->realTextBetween(),
        ];
    }
}
