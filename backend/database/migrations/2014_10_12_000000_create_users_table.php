<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone_portable');
            $table->string('telephone_fixe')->nullable();
            $table->string('mot_de_passe');
            $table->string('photo_path')->nullable(); // Added photo path column
            $table->enum('role',['parent','admin','animateur'])->default('parent');
            
            $table->timestamps();
        });
         // contrainte de format d'email valid
            DB::statement('ALTER TABLE users ADD CONSTRAINT email_format_check CHECK (email ~* \'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$\')');
         // contrainte de format de numéro de portable valide (commence par 06  07  et contient 10 chiffres)
            DB::statement("ALTER TABLE users ADD CONSTRAINT telephone_portable_format_check CHECK (telephone_portable::text ~* '^(06|07)[0-9]{8}$')");
        // contrainte de format de numéro de fixe valide (commence par 05  et contient 10 chiffres)
            DB::statement("ALTER TABLE users ADD CONSTRAINT telephone_fixe_format_check CHECK (telephone_fixe::text ~* '^(05)[0-9]{8}$')");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
