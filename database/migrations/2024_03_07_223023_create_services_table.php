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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('responsable_id')->nullable();
            // $table->foreign('responsable_id')->references('id')->on('personnes')->onDelete('set null');
            //ON MySQL =>ALTER TABLE services ADD FOREIGN KEY(responsable_id) REFERENCES personnes(id)
            $table->integer('nombre_employes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
