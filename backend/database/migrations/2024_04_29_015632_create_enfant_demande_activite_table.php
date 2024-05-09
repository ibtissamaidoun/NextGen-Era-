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
        Schema::create('enfant_demande_activite', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedInteger('enfant_id');
            $table->foreign('enfant_id')
                  ->references('id')
                  ->on('enfants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedInteger('activite_id');
            $table->foreign('activite_id')
                  ->references('id')
                  ->on('activites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->unsignedInteger('demande_id');
            $table->foreign('demande_id')
                  ->references('id')
                  ->on('demandes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->primary([ 'enfant_id','activite_id','demande_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfant_demande_activite');
    }
};
