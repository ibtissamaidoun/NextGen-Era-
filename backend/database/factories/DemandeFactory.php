<?php

namespace Database\Factories;

use App\Models\Administrateur;
use App\Models\Demande;
use App\Models\Offre;
use App\Models\Pack;
use App\Models\Paiement;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Demande::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Générer des dates de demande et de traitement aléatoires
        $dateDemande = $this->faker->dateTimeBetween('-1 year', 'now');
        $dateTraitement = $this->faker->dateTimeBetween($dateDemande, 'now');
    
        // Définir les différentes options pour le statut
        $statuts = ['valide', 'refuse', 'en cours', 'brouillon', 'paye'];
    
        // Sélectionner un administrateur existant aléatoirement
        $administrateurId = Administrateur::inRandomOrder()->first()->id;
    
        // Sélectionner une offre existante aléatoirement ou null
        $offreId = $this->faker->randomElement([Offre::inRandomOrder()->first()->id, null]);
        $packId = null;
    
        if ($offreId === null) {
            // Si offre_id est null, sélectionner un pack existant aléatoirement ou null
            $packId = Pack::inRandomOrder()->first()->id;
        }
    
        // Sélectionner un paiement existant aléatoirement ou null
        $paiementId = Paiement::inRandomOrder()->first()->id;
    
        // Sélectionner un parent existant aléatoirement
        $parentModelId = ParentModel::inRandomOrder()->first()->id;
    
        // Choisir un statut
        $statut = $this->faker->randomElement($statuts);
    
        // Définir le motif de refus si le statut est "refuse"
        $motifRefus = ($statut === 'refuse') ? $this->faker->text() : null;
    
        return [
            'date_demande' => $dateDemande,
            'date_traitement' => $dateTraitement,
            'statut' => $statut,
            'administrateur_id' => $administrateurId,
            'offre_id' => $offreId,
            'pack_id' => $packId,
            'paiement_id' => $paiementId,
            'parentmodel_id' => $parentModelId,
            'motif_refus' => $motifRefus,
        ];
    }
    
}
