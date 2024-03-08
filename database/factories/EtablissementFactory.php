<?php

namespace Database\Factories;

use App\Models\Personne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etablissement>
 */
class EtablissementFactory extends Factory
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
        return [
            'nom' => $this->faker->company,
            'adresse' => $this->faker->address,
            'directeur_id' => $randomPersonneId
        ];
    }
}
