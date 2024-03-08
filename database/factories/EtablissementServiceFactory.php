<?php

namespace Database\Factories;

use App\Models\Etablissement;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EtablissementService>
 */
class EtablissementServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $etablissementIds = Etablissement::pluck('id')->toArray();
        $serviceIds = Service::pluck('id')->toArray();

        return [
            'etablissement_id' => $this->faker->randomElement($etablissementIds),
            'service_id' => $this->faker->randomElement($serviceIds),
        ];
    }
}
