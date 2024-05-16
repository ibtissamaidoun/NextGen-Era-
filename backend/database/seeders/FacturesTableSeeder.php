<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facture;

class FacturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crée une facture pour le devi_id 1
        Facture::create([
            'facture_pdf' => 'chemin/vers/facture1.pdf',
            'devi_id' => 1,
        ]);

        // Crée une facture pour le devi_id 4
        Facture::create([
            'facture_pdf' => 'chemin/vers/facture2.pdf',
            'devi_id' => 4,
        ]);
    }
}
