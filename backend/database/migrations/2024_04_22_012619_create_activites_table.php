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
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->text('objectifs');
            $table->string('image_pub', 255); 
            $table->string('fiche_pdf',255);
            $table->text('lien_youtube');
            // new
                $table->enum('nbr_seances_semaine',[1,2]);
                $table->decimal('tarif', 8, 2);
                $table->integer('effectif_min');
                $table->integer('effectif_max');
                $table->integer('effectif_actuel');
                $table->integer('age_min');
                $table->integer('age_max');
                $table->enum('status',['active','inactive'])->default('inactive');
                $table->date('date_debut_etud');
                $table->date('date_fin_etud');
            // fin new
            $table->timestamps();
            // je ne vais pas utiliser enum pour que l'admin ait la possibilité d'ajouter d'autre type
            $table->string('type_activite');
            $table->string('domaine_activite');
            $table->unsignedInteger('administrateur_id'); // Colonne pour la clé étrangère
            // Définition de la contrainte de clé étrangère
            $table->foreign('administrateur_id')
                  ->references('id')
                  ->on('administrateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activites');
    }
};
