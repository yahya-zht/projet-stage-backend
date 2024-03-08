<?php

namespace Database\Factories;

use App\Models\Personne;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $personneIds = Personne::pluck('id')->toArray();
        $randomPersonneId = $this->faker->randomElement($personneIds);
        return [
            'nom' => $this->faker->word,
            'responsable_id' => $randomPersonneId,
            'nombre_employes' => $this->faker->numberBetween(1, 100),
        ];
    }
}
