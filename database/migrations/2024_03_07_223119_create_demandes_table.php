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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->date('date_demande');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('état');
            $table->unsignedBigInteger('personne_id');
            $table->unsignedBigInteger('conge_id')->nullable();
            $table->foreign('personne_id')->references('id')->on('personnes')->onDelete('cascade');
            $table->foreign('conge_id')->references('id')->on('conges')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
