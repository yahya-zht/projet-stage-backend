<?php

namespace Database\Seeders;

use App\Models\Echelle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EchelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Echelle::factory(20)->create();
    }
}
