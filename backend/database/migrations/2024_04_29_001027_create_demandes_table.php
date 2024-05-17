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
            $table->date('date_demande')->nullable();
            $table->date('date_traitement')->nullable();
            $table->enum('statut',['valide','refuse','en cours','brouillon','paye','annule'])->default('brouillon');
            $table->text('motif_refus')->nullable();
            $table->timestamps();
            $table->unsignedInteger('administrateur_id')->nullable(); //nullable s'il l'administrateur n'a pas encore traité la demande
            $table->foreign('administrateur_id')
                  ->references('id')
                  ->on('administrateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedInteger('offre_id')->nullable(); //si NULL donc le parent a choisi des activites indépendants de l'offre
            $table->foreign('offre_id')
                  ->references('id')
                  ->on('offres')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->foreign('pack_id')
                  ->references('id')
                  ->on('packs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedBigInteger('paiement_id')->nullable();
            $table->foreign('paiement_id')
                  ->references('id')
                  ->on('paiements')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');      
            $table->unsignedBigInteger('parentmodel_id');
            $table->foreign('parentmodel_id')
                        ->references('id')
                        ->on('parentmodels')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');            
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
