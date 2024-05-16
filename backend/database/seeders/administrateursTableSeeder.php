<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrateur;

class AdministrateursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Administrateur::create([
            'user_id' => 1, 
        ]);

        // Ajoutez d'autres administrateurs en utilisant des utilisateurs existants si nécessaire
    }
}
