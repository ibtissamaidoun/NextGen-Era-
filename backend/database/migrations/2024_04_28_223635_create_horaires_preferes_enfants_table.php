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
        Schema::create('horaires_preferes_enfants', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('enfant_id');
            $table->integer('ordre')->unique(); 
            $table->foreign('enfant_id')
                  ->references('id')
                  ->on('enfants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedBigInteger('horaire_id');
            $table->foreign('horaire_id')
                  ->references('id')
                  ->on('horaires')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->primary(['horaire_id', 'enfant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horaires_preferes_enfants');
    }
};
