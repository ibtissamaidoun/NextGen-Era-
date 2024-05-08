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
        Schema::create('paiement_activite', function (Blueprint $table) {
            $table->unsignedInteger('paiement_id');
            $table->foreign('paiement_id')
                  ->references('id')
                  ->on('paiements')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedInteger('activite_id');
            $table->foreign('activite_id')
                  ->references('id')
                  ->on('activites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->integer('remise');
            $table->primary([ 'paiement_id','activite_id','remise']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_activite');
    }
};
