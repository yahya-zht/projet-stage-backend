<?php

namespace Database\Factories;

use App\Models\Absence;
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
        $absenceIds = Absence::pluck('id')->toArray();

        return [
            'dataDemande' => $this->faker->date(),
            'dataDebut' => $this->faker->date(),
            'dataFin' => $this->faker->date(),
            'état' => $this->faker->randomElement(['acceptable', 'REJETÉ', 'en attendant']),
            'absence_id' => $this->faker->randomElement($absenceIds),
            'personne_id' => $this->faker->randomElement($personneIds),
        ];
    }
}
