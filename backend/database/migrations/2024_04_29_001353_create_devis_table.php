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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->enum('statut',['valide','refuse','en attente'])->default('en attente');
            $table->text('motif_refus')->nullable();
            $table->decimal('tarif_ht', 8, 2);
            $table->decimal('tarif_ttc', 8, 2);
            $table->decimal('tva', 8, 2);
            $table->string('devi_pdf',255)->unique();
            $table->unsignedInteger('demande_id');
            $table->foreign('demande_id')
                  ->references('id')
                  ->on('demandes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade'); 
            $table->unsignedBigInteger('parentmodel_id');
            $table->foreign('parentmodel_id')
                  ->references('id')
                  ->on('parentmodels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
}; 
