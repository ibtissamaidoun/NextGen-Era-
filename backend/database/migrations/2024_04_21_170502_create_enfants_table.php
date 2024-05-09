<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enfants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_de_naissance');
            $table->enum('niveau_etude', ['Primaire', 'College', 'Lycee']);
            $table->timestamps();
            $table->unsignedBigInteger('parentmodel_id'); // Colonne pour la clé étrangère
    
            // Contrainte de clé étrangère
            $table->foreign('parentmodel_id')
                  ->references('id')
                  ->on('parentmodels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
         });
            // Contrainte CHECK pour la date de naissance pour que l'age soit entre 6ans et 17ans
            // J'ai ajouté une marge pour ne pas être obligé de modifier la contrainte chaque année
            DB::statement('ALTER TABLE enfants ADD CONSTRAINT age_check 
            CHECK (date_de_naissance >= CURRENT_DATE - INTERVAL \'17 years\' 
            AND date_de_naissance <= CURRENT_DATE - INTERVAL \'6 years\')') ;
      
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfants');
    }
};
