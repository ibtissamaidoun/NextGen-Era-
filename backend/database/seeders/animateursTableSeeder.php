<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animateur;

class AnimateursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créez un animateur et associez-le à un utilisateur existant
        Animateur::create([
            'domaine_competence' => 'Informatique',
            'user_id' => 3, 
        ]);

        Animateur::create([
            'domaine_competence' => 'biologie',
            'user_id' => 5, 
        ]);


        Animateur::create([
            'domaine_competence' => 'mathematique',
            'user_id' => 6, 
        ]);


        Animateur::create([
            'domaine_competence' => 'mathematique',
            'user_id' => 7, 
        ]);

        // Ajoutez d'autres animateurs en utilisant des utilisateurs existants si nécessaire
    }
}
