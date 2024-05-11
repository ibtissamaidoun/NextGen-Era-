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
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->integer('remise')->default(0);
            $table->timestamps();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedInteger('administrateur_id'); // Colonne pour la clé étrangère
            // Définition de la contrainte de clé étrangère
            $table->foreign('administrateur_id')
                  ->references('id')
                  ->on('administrateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedInteger('paiement_id');
            $table->foreign('paiement_id')
            ->references('id')
            ->on('paiements')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
