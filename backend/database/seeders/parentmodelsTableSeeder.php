<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parentmodel;

class ParentmodelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parentmodel::create([
            'fonction' => 'chauffeur',
            'user_id' => 2, // Remplacez 2 par l'ID de l'utilisateur parent existant auquel vous souhaitez associer ce parent
        ]);

        Parentmodel::create([
            'fonction' => 'technicien',
            'user_id' => 4, // Remplacez 2 par l'ID de l'utilisateur parent existant auquel vous souhaitez associer ce parent
        ]);

        // Ajoutez d'autres parents en utilisant des utilisateurs existants si nécessaire
    }
}
