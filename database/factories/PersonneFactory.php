<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personne>
 */
class PersonneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'age' => $this->faker->numberBetween(18, 80),
            'fonction' => $this->faker->jobTitle,
            'catégorie' => $this->faker->randomElement(['A', 'B', 'C']),
        ];
    }
}
