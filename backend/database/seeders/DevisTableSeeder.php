<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Devi;

class DevisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crée un devis avec des données fictives
        Devi::create([
            'statut' => 'valide',
            'motif_refus' => null,
            'tarif_ht' => 1000.00,
            'tarif_ttc' => 1200.00,
            'tva' => 20.00,
            'devi_pdf' => 'chemin/vers/devi.pdf',
            'demande_id' => 1, // ID de la demande associée
            'parentmodel_id' => 1, // ID du parent associé
        ]);

        Devi::create([
            'statut' => 'refuse',
            'motif_refus' => 'Raison du refus 1',
            'tarif_ht' => 1500.00,
            'tarif_ttc' => 1800.00,
            'tva' => 20.00,
            'devi_pdf' => 'chemin/vers/devi2.pdf',
            'demande_id' => 2, // ID de la demande associée
            'parentmodel_id' => 2, // ID du parent associé
        ]);

        Devi::create([
            'statut' => 'en attente',
            'motif_refus' => null,
            'tarif_ht' => 2000.00,
            'tarif_ttc' => 2400.00,
            'tva' => 20.00,
            'devi_pdf' => 'chemin/vers/devi3.pdf',
            'demande_id' => 3, // ID de la demande associée
            'parentmodel_id' => 1, // ID du parent associé
        ]);

        Devi::create([
            'statut' => 'valide',
            'motif_refus' => null,
            'tarif_ht' => 3000.00,
            'tarif_ttc' => 3600.00,
            'tva' => 20.00,
            'devi_pdf' => 'chemin/vers/devi4.pdf',
            'demande_id' => 4, // ID de la demande associée
            'parentmodel_id' => 2, // ID du parent associé
        ]);
    }
}
