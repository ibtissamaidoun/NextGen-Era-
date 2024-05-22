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
        Schema::create('recus', function (Blueprint $table) {
            $table->id();
            $table->date('date_paiement');
            $table->integer('traite');
            $table->integer('total_traite');
            $table->decimal('tarif_traite', 8, 2);
            $table->date('date_prochain_paiement');
            $table->string('recu_pdf');
            $table->unsignedBigInteger('facture_id');
            $table->foreign('facture_id')
            ->references('id')
            ->on('factures')
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
        Schema::dropIfExists('recus');
    }
};
