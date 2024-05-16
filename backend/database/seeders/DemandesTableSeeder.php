<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Demande;

class DemandesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créez une demande avec des données fictives
        Demande::create([
            'date_demande' => now(),
            'date_traitement' => now(),
            'statut' => 'valide',
            'administrateur_id' => 1, // ID de l'administrateur
            'offre_id' => 1, // ID de l'offre
            'paiement_id' => 1, // ID du paiement
            'parentmodel_id' => 1, // ID du parent concerné
        ]);

        Demande::create([
            'date_demande' => now(),
            'date_traitement' => now(),
            'statut' => 'refuse',
            'motif_refus' => 'Motif de refus de la demande',
            'administrateur_id' => 1, // ID de l'administrateur
            'offre_id' => 2, // ID de l'offre
            'paiement_id' => 3, // ID du paiement
            'parentmodel_id' => 2, // ID du parent concerné
        ]);

        Demande::create([
            'date_demande' => now(),
            'date_traitement' => now(),
            'statut' => 'valide',
            'administrateur_id' => 1, // ID de l'administrateur
            'pack_id' => 1, // ID du pack
            'paiement_id' => 1, // ID du paiement
            'parentmodel_id' => 2, // ID du parent concerné
        ]);

        Demande::create([
            'date_demande' => now(),
            'date_traitement' => now(),
            'statut' => 'valide',
            'administrateur_id' => 1, // ID de l'administrateur
            'pack_id' => 2, // ID du pack
            'paiement_id' => 1, // ID du paiement
            'parentmodel_id' => 1, // ID du parent concerné
        ]);

        Demande::create([
            'date_demande' => now(),
            'date_traitement' => now(),
            'statut' => 'refuse',
            'motif_refus' => 'Motif de refus de la demande',
            'administrateur_id' => 1, // ID de l'administrateur
            'offre_id' => 3, // ID de l'offre
            'paiement_id' => 1, // ID du paiement
            'parentmodel_id' => 1, // ID du parent concerné
        ]);
    }
}
