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
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('duree');
            $table->string('type');
            $table->unsignedBigInteger('personne_id')->nullable();
            $table->unsignedBigInteger('demande_conge_id')->nullable();
            $table->foreign('personne_id')->references('id')->on('personnes')->onDelete('set null');
            $table->foreign('demande_conge_id')->references('id')->on('demande_conges')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
