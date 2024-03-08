<?php

namespace Database\Factories;

use App\Models\Conge;
use App\Models\Personne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demande>
 */
class DemandeFactory extends Factory
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
            'date_demande' => $this->faker->date(),
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'état' => $this->faker->randomElement(['acceptable', 'REJETÉ', 'en attendant']),
            'personne_id' => $this->faker->randomElement($personneIds),
            'conge_id' => $this->faker->randomElement($congeIds),
        ];
    }
}
