<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('type');
            $table->integer('duree');
            // $table->unsignedBigInteger('certificatMedical_id');
            // $table->foreign('certificatMedical_id')->references('id')->on('certificat_medical')->onDelete('cascade');
            $table->unsignedBigInteger('demande_absence_id')->nullable();
            $table->unsignedBigInteger('personne_id');
            $table->foreign('demande_absence_id')->references('id')->on('demande_absences')->onDelete('cascade');
            $table->foreign('personne_id')->references('id')->on('personnes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
