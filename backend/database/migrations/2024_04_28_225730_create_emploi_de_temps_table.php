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
        Schema::create('emploi_de_temps', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('enfant_id');
            $table->foreign('enfant_id')
                  ->references('id')
                  ->on('enfants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedBigInteger('activite_id');
            $table->foreign('activite_id')
                  ->references('id')
                  ->on('activites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->integer('horaire_1');
            $table->integer('horaire_2')->nullable();// il peut qu'il aura qu'une seule séance
             $table->primary(['activite_id', 'enfant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emploi_de_temps');
    }
};
