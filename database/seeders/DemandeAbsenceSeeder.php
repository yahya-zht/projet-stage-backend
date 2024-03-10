<?php

namespace Database\Seeders;

use App\Models\DemandeAbsence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandeAbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DemandeAbsence::factory(20)->create();
    }
}
