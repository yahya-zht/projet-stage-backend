<?php

namespace Database\Factories;

use App\Models\Personne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DemandeConge>
 */
class DemandeCongeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $personneIds = Personne::pluck('id')->toArray();
        return [
            'Ref' => $this->faker->unique()->word(),
            'dateDemande' => $this->faker->date(),
            'dateDebut' => $this->faker->date(),
            'dateFin' => $this->faker->date(),
            'état' => $this->faker->randomElement(['Acceptable', 'REJETÉ', 'En Attendant']),
            'duree' => $this->faker->numberBetween(1, 30),
            'type' => $this->faker->randomElement([
                'Congé', 'Congé Maladie', 'Congé Maternité', 'Congé sans solde', 'Congé de paternité',
                'Congé de formation', 'Congé sabbatique', 'Congé pour mariage'
            ]),
            'personne_id' => $this->faker->randomElement($personneIds),

        ];
    }
}
