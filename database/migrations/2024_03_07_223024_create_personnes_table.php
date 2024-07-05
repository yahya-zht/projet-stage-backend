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
        Schema::create('personnes', function (Blueprint $table) {
            $table->id();
            $table->string('CIN')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('adresse');
            $table->string('telephone');
            $table->integer('solde_conge')->default(0);
            $table->integer('NBabsence')->default(0);
            $table->string('role');
            $table->unsignedBigInteger('chef_id')->nullable();
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('fonction_id');
            $table->unsignedBigInteger('echelle_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('etablissement_id');
            $table->foreign('chef_id')->references('id')->on('personnes')->onDelete('set null');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('fonction_id')->references('id')->on('fonctions')->onDelete('cascade');
            $table->foreign('echelle_id')->references('id')->on('echelles')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnes');
    }
};
