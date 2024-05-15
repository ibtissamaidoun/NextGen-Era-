<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enfant;

class enfantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enfant::create([
            'nom' => 'aya' ,
            'prenom' => 'ahmyttou' ,
            'date_de_naissance' => '2010-03-23',
            'niveau_etude' => ['Primaire', 'College', 'Lycee'][rand(0, 2)], // Choisissez aléatoirement un niveau d'étude
            'parentmodel_id' => 2,
        ]);

        Enfant::create([
            'nom' => 'mohamed' ,
            'prenom' => 'jouali' ,
            'date_de_naissance' => '2010-03-23',
            'niveau_etude' => ['Primaire', 'College', 'Lycee'][rand(0, 2)], // Choisissez aléatoirement un niveau d'étude
            'parentmodel_id' => 2,
        ]);

        Enfant::create([
            'nom' => 'ahmed' ,
            'prenom' => 'fahsi' ,
            'date_de_naissance' => '2010-03-23',
            'niveau_etude' => ['Primaire', 'College', 'Lycee'][rand(0, 2)], // Choisissez aléatoirement un niveau d'étude
            'parentmodel_id' => 2,
        ]);

        Enfant::create([
            'nom' => 'amine' ,
            'prenom' => 'berkoukt' ,
            'date_de_naissance' => '2010-03-23',
            'niveau_etude' => ['Primaire', 'College', 'Lycee'][rand(0, 2)], // Choisissez aléatoirement un niveau d'étude
            'parentmodel_id' => 1,
        ]);


        Enfant::create([
            'nom' => 'soufiane' ,
            'prenom' => 'joudar' ,
            'date_de_naissance' => '2010-03-23',
            'niveau_etude' => ['Primaire', 'College', 'Lycee'][rand(0, 2)], // Choisissez aléatoirement un niveau d'étude
            'parentmodel_id' => 1,
        ]);

        Enfant::create([
            'nom' => 'houssam' ,
            'prenom' => 'ghailani' ,
            'date_de_naissance' => '2010-03-23',
            'niveau_etude' => ['Primaire', 'College', 'Lycee'][rand(0, 2)], // Choisissez aléatoirement un niveau d'étude
            'parentmodel_id' => 1,
        ]);
    }
}
