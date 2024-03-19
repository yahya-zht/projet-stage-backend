<?php

namespace Database\Factories;

use App\Models\DemandeAbsence;
use App\Models\Personne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $PersonneIds = Personne::pluck('id')->toArray();
        $randomPersonneId = $this->faker->randomElement($PersonneIds);
        $demande_absenceIds = DemandeAbsence::pluck('id')->toArray();
        return [
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'type' => $this->faker->randomElement(['Maladie', ' Maternité', 'formation']),
            'duree' => $this->faker->numberBetween(1, 30),
            'demande_absence_id' => $this->faker->randomElement($demande_absenceIds),
            'personne_id' => $randomPersonneId
        ];
    }
}
