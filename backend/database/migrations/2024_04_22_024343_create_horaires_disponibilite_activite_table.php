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
        Schema::create('horaires_disponibilite_activite', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('activite_id');
            $table->foreign('activite_id')
                  ->references('id')
                  ->on('activites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedBigInteger('horaire_id');
            $table->foreign('horaire_id')
                  ->references('id')
                  ->on('horaires')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->primary(['horaire_id', 'activite_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horaires_disponibilite_activite');
    }
};
