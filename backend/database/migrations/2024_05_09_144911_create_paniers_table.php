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
        Schema::create('paniers', function (Blueprint $table) {
            $table->enum('status',['valide','en attente'])->default('en attente');
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
            $table->unsignedInteger('parentmodel_id');
            $table->foreign('parentmodel_id')
                  ->references('id')
                  ->on('parentmodels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->primary([ 'enfant_id','activite_id','parentmodel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paniers');
    }
};
