<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paiement;


class paiementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Paiement::create([
            'option_paiement' => 'mensuel',
        ]);

        Paiement::create([
            'option_paiement' => 'annuel',
        ]);

        Paiement::create([
            'option_paiement' => 'trimestriel',
        ]);

        Paiement::create([
            'option_paiement' => 'semestriel',
        ]);
    }
}
