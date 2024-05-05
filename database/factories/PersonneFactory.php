<?php

namespace Database\Factories;

use App\Models\Echelle;
use App\Models\Etablissement;
use App\Models\Fonction;
use App\Models\Grade;
use App\Models\Personne;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personne>
 */
class PersonneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $faker = Faker::create('ar_JO');
        $faker = Faker::create('fr_FR');
        $GradeIds = Grade::pluck('id')->toArray();
        $randomGradeId = $faker->randomElement($GradeIds);
        $FonctionIds = Fonction::pluck('id')->toArray();
        $randomFonctionId = $faker->randomElement($FonctionIds);
        $EchelleIds = Echelle::pluck('id')->toArray();
        $randomEchelleId = $faker->randomElement($EchelleIds);
        $ServiceIds = Service::pluck('id')->toArray();
        $randomServiceId = $faker->randomElement($ServiceIds);
        $PersonneIds = Personne::pluck('id')->toArray();
        $randomPersonneId = $faker->randomElement($PersonneIds);
        $EtablissementIds = Etablissement::pluck('id')->toArray();
        $randomEtablissementId = $faker->randomElement($EtablissementIds);
        // return [
        //     'nom' => $this->faker->lastName,
        //     'prenom' => $this->faker->firstName,
        //     'date_naissance' => $this->faker->date(),
        //     'adresse' => $this->faker->address,
        //     'telephone' => $this->faker->phoneNumber,
        //     'role' => $this->faker->randomElement(['Manager', 'Employee', 'Supervisor']),
        //     'chef_id' => $randomPersonneId,
        //     'grade_id' => $randomGradeId,
        //     'fonction_id' => $randomFonctionId,
        //     'echelle_id' => $randomEchelleId,
        //     'service_id' => $randomServiceId,
        // ];
        return [
            'nom' => $faker->lastName,
            'prenom' => $faker->firstName,
            'CIN' => $faker->numerify('#####'),
            'date_naissance' => $faker->date(),
            'adresse' => $faker->address,
            'telephone' => $faker->phoneNumber,
            'solde_congés' => $faker->numberBetween(0, 28),
            'NBabsence' => $faker->numberBetween(0, 50),
            'role' => $faker->randomElement(['Directeur', 'Employé', 'Superviseur']),
            'chef_id' => $randomPersonneId,
            'grade_id' => $randomGradeId,
            'fonction_id' => $randomFonctionId,
            'echelle_id' => $randomEchelleId,
            'service_id' => $randomServiceId,
            'etablissement_id' => $randomEtablissementId,
        ];
    }
}
