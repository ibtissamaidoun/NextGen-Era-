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
        Schema::create('activite_animateur_horaire', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedInteger('animateur_id');
            $table->foreign('animateur_id')
                  ->references('id')
                  ->on('animateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedInteger('activite_id');
            $table->foreign('activite_id')
                  ->references('id')
                  ->on('activites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->unsignedInteger('horaire_id');
            $table->foreign('horaire_id')
                  ->references('id')
                  ->on('horaires')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->primary(['horaire_id', 'animateur_id']);
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activite_animateur_horaire');
    }
};
