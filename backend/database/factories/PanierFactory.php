<?php

namespace Database\Factories;

use App\Models\Panier;
use App\Models\Enfant;
use App\Models\Activite;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PanierFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Panier::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        // Sélectionner un enfant existant aléatoirement
        $enfantId = Enfant::inRandomOrder()->first()->id;

        // Sélectionner une activité existante aléatoirement
        $activiteId = Activite::inRandomOrder()->first()->id;

        // Sélectionner un parent model existant aléatoirement
        $parentModelId = ParentModel::inRandomOrder()->first()->id;

        return [
            'status' => 'en attente', // Statut "en attente"
            'enfant_id' => $enfantId,
            'activite_id' => $activiteId,
            'parentmodel_id' => $parentModelId,
        ];
    }
}
