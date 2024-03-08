<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conge>
 */
class CongeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'duree' => $this->faker->numberBetween(1, 30),
            'type' => $this->faker->randomElement([
                'Congé', 'Congé Maladie', 'Congé Maternité', 'Congé sans solde', 'Congé de paternité',
                'Congé de formation', 'Congé sabbatique', 'Congé pour mariage'
            ]),
        ];
    }
}
