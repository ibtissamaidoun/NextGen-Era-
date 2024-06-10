<?php

namespace Database\Factories;

use App\Models\offreActivite;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffreActiviteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OffreActivite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Sélectionner un offre_id aléatoire
            'offre_id' => function () {
                // Tente de trouver une offre existante et utilise son id. Si aucune offre n'existe, crée une nouvelle offre et utilise son id.
                return \App\Models\Offre::inRandomOrder()->first()?->id ?? \App\Models\Offre::factory()->create()->id;
            },

            // Sélectionner un activite_id aléatoire
            'activite_id' => function () {
                // Tente de trouver une activité existante et utilise son id. Si aucune activité n'existe, crée une nouvelle activité et utilise son id.
                return \App\Models\Activite::inRandomOrder()->first()?->id ?? \App\Models\Activite::factory()->create()->id;
            }
        ];
    }
}
