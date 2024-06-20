<?php

namespace Database\Factories;

use App\Models\Devi;
use App\Models\Demande;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Devi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuts = ['valide', 'refuse', 'en attente'];
        $statut = $this->faker->randomElement($statuts);
        $motifRefus = $statut === 'refuse' ? $this->faker->text : null;

        // Générer des tarifs aléatoires
        $tarifHt = $this->faker->randomFloat(2, 100, 1000);
        $tva = 20; // Définir la TVA à 20%
        $tarifTtc = $tarifHt * (1 + $tva / 100);

        // Sélectionner une demande existante aléatoirement
        $demandeId = Demande::inRandomOrder()->first()->id;

        // Sélectionner un parent existant aléatoirement
        $parentModelId = ParentModel::inRandomOrder()->first()->id;

        return [
            'statut' => $statut,
            'motif_refus' => $motifRefus,
            'tarif_ht' => $tarifHt,
            'tva' => $tva,
            'tarif_ttc' => $tarifTtc,
            'devi_pdf' => $this->faker->word . '.pdf', // Générer un nom de fichier PDF aléatoire
            'demande_id' => $demandeId,
            'parentmodel_id' => $parentModelId,
        ];
    }
}
