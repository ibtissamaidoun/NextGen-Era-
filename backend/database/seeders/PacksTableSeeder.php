<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pack;

class PacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créez deux packs avec des données différentes
        Pack::create([
            'description' => 'Pack pour enfants',
            'type' => 'enfants',
            'remise' => 40,
        ]);

        Pack::create([
            'description' => 'Pack pour activités',
            'type' => 'activite',
            'remise' => 40,
        ]);
    }
}

