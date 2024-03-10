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
        Schema::create('certificat_medical', function (Blueprint $table) {
            $table->id();
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->string('medecin');
            $table->string('diagnostic');
            $table->date('dateEmission');
            $table->string('validite');
            $table->string('etablissement');
            $table->unsignedBigInteger('absence_id')->nullable();
            $table->foreign('absence_id')->references('id')->on('absences')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificat_medical');
    }
};
