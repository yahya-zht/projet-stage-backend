<?php

namespace Database\Seeders;

use App\Models\EtablissementService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EtablissementService::factory(20)->create();
    }
}
