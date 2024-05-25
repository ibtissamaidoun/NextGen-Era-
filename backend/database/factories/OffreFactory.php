<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\Administrateur;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Sélectionner un administrateur existant aléatoirement
        $administrateurId = Administrateur::inRandomOrder()->first()->id;

        // Sélectionner un paiement existant aléatoirement
        $paiementId = Paiement::inRandomOrder()->first()->id ;

        return [
            'titre' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'remise' => $this->faker->numberBetween(0, 50), // Remise aléatoire entre 0 et 50
            'date_debut' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'), // Date de début aléatoire dans le mois prochain
            'date_fin' => $this->faker->dateTimeBetween('+1 month', '+6 months')->format('Y-m-d'), // Date de fin aléatoire entre 1 mois et 6 mois à partir de la date de début
            'administrateur_id' => $administrateurId,
            'paiement_id' => $paiementId,
        ];
    }
}
