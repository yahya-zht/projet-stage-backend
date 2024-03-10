<?php

namespace Database\Factories;

use App\Models\Absence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CertificatMedical>
 */
class CertificatMedicalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $absenceIds = Absence::pluck('id')->toArray();
        return [
            'dateDebut' => $this->faker->date(),
            'dateFin' => $this->faker->date(),
            'medecin' => $this->faker->name(),
            'diagnostic' => $this->faker->text(),
            'dateEmission' => $this->faker->date(),
            'validite' => $this->faker->randomElement(['acceptable', 'REJETÉ', 'en attendant']),
            'etablissement' => $this->faker->word(),
            'absence_id' => $this->faker->randomElement($absenceIds),
        ];
    }
}
