<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offre;

class OffresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offre::create([
            'titre' => 'ramadan',
            'description' => 'c est une oportunité ',
            'remise' => 20, 
            'date_debut' => now(), 
            'date_fin' => now()->addDays(30), // Date de fin de l'offre (30 jours à partir de maintenant)
            'administrateur_id' => 1, // ID de l'administrateur
            'paiement_id' => 1, 
        ]);

        Offre::create([
            'titre' => 'printemps',
            'description' => 'c est une oportunité ',
            'remise' => 30, 
            'date_debut' => now(), 
            'date_fin' => now()->addDays(30), // Date de fin de l'offre (30 jours à partir de maintenant)
            'administrateur_id' => 1, // ID de l'administrateur
            'paiement_id' => 3, 
        ]);


        Offre::create([
            'titre' => 'été',
            'description' => 'c est une oportunité ',
            'remise' => 20, 
            'date_debut' => now(), 
            'date_fin' => now()->addDays(30), 
            'administrateur_id' => 1,
            'paiement_id' => 4, 
        ]);
    }
}
