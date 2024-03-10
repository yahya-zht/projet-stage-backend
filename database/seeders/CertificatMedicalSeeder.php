<?php

namespace Database\Seeders;

use App\Models\CertificatMedical;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificatMedicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CertificatMedical::factory(20)->create();
    }
}
