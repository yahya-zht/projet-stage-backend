<?php

namespace Database\Factories;

use App\Models\Conge;
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
        $congeIds = Conge::pluck('id')->toArray();

        return [
            'dataDemande' => $this->faker->date(),
            'dataDebut' => $this->faker->date(),
            'dataFin' => $this->faker->date(),
            'état' => $this->faker->randomElement(['acceptable', 'REJETÉ', 'en attendant']),
            'personne_id' => $this->faker->randomElement($personneIds),
            'conge_id' => $this->faker->randomElement($congeIds),
        ];
    }
}