<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horaire; // Import du modèle Horaire

class HorairesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Horaire::create([
            'jour_semaine' => 'Lundi',
            'heure_debut' => '17:00',
            'heure_fin' => '18:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Lundi',
            'heure_debut' => '19:00',
            'heure_fin' => '20:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Lundi',
            'heure_debut' => '21:00',
            'heure_fin' => '22:30',
        ]);  
        
        Horaire::create([
            'jour_semaine' => 'Lundi',
            'heure_debut' => '19:00',
            'heure_fin' => '22:00',
        ]);  

        Horaire::create([
            'jour_semaine' => 'Mardi',
            'heure_debut' => '17:00',
            'heure_fin' => '18:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Mardi',
            'heure_debut' => '19:00',
            'heure_fin' => '20:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Mardi',
            'heure_debut' => '21:00',
            'heure_fin' => '22:30',
        ]);  
        
        Horaire::create([
            'jour_semaine' => 'Mardi',
            'heure_debut' => '19:00',
            'heure_fin' => '22:00',
        ]);  



        Horaire::create([
            'jour_semaine' => 'Mercredi',
            'heure_debut' => '17:00',
            'heure_fin' => '18:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Mercredi',
            'heure_debut' => '19:00',
            'heure_fin' => '20:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Mercredi',
            'heure_debut' => '21:00',
            'heure_fin' => '22:30',
        ]);  
        
        Horaire::create([
            'jour_semaine' => 'Mercredi',
            'heure_debut' => '19:00',
            'heure_fin' => '22:00',
        ]);  


        Horaire::create([
            'jour_semaine' => 'Jeudi',
            'heure_debut' => '17:00',
            'heure_fin' => '18:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Jeudi',
            'heure_debut' => '19:00',
            'heure_fin' => '20:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Jeudi',
            'heure_debut' => '21:00',
            'heure_fin' => '22:30',
        ]);  
        
        Horaire::create([
            'jour_semaine' => 'Jeudi',
            'heure_debut' => '19:00',
            'heure_fin' => '22:00',
        ]);  
        
        

        Horaire::create([
            'jour_semaine' => 'Vendredi',
            'heure_debut' => '17:00',
            'heure_fin' => '18:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Vendredi',
            'heure_debut' => '19:00',
            'heure_fin' => '20:30',
        ]);   

        Horaire::create([
            'jour_semaine' => 'Vendredi',
            'heure_debut' => '21:00',
            'heure_fin' => '22:30',
        ]);  
        
        Horaire::create([
            'jour_semaine' => 'Vendredi',
            'heure_debut' => '19:00',
            'heure_fin' => '22:00',
        ]);  
    }
}
