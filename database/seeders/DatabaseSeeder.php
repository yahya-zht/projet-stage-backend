<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Absence;
use App\Models\CertificatMedical;
use App\Models\Conge;
use App\Models\DemandeAbsence;
use App\Models\DemandeConge;
use App\Models\Echelle;
use App\Models\Etablissement;
use App\Models\EtablissementService;
use App\Models\Fonction;
use App\Models\Grade;
use App\Models\Personne;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        Fonction::factory(20)->create();
        Echelle::factory(20)->create();
        Grade::factory(20)->create();
        Service::factory(20)->create();
        Personne::factory(20)->create();
        Etablissement::factory(20)->create();
        Absence::factory(20)->create();
        Conge::factory(20)->create();
        DemandeAbsence::factory(20)->create();
        DemandeConge::factory(20)->create();
        CertificatMedical::factory(20)->create();
        EtablissementService::factory(20)->create();


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
