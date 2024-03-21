<?php

namespace Database\Factories;

use App\Models\Personne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CertificatMedical>
 */
class DemandeAbsenceFactory extends Factory
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
            'dateDemande' => $this->faker->date(),
            'dateDebut' => $this->faker->date(),
            'dateFin' => $this->faker->date(),
            'état' => $this->faker->randomElement(['Acceptable', 'REJETÉ', 'En Attendant']),
            'type' => $this->faker->randomElement(['Maladie', ' Maternité', 'formation']),
            'duree' => $this->faker->numberBetween(1, 30),
            'personne_id' => $this->faker->randomElement($personneIds),
        ];
    }
}
