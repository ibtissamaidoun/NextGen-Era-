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
        Schema::create('offre_paiement_activite', function (Blueprint $table) {
            $table->enum('nbr_seances_semaine',[1,2]);
            $table->decimal('tarif', 8, 2);
            $table->integer('effectif_min');
            $table->integer('effectif_max');
            $table->integer('age_min');
            $table->integer('age_max');
            $table->timestamps();
            $table->unsignedInteger('offre_id');
            $table->foreign('offre_id')
                  ->references('id')
                  ->on('offres')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedInteger('activite_id');
            $table->foreign('activite_id')
                  ->references('id')
                  ->on('activites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->unsignedInteger('paiement_id');
            $table->foreign('paiement_id')
                  ->references('id')
                  ->on('paiements')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  
            $table->primary([ 'offre_id','activite_id','paiement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre_paiement_activite');
    }
};
