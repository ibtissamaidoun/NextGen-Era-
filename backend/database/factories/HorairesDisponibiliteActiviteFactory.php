<?php

namespace Database\Factories;

use App\Models\HorairesDisponibiliteActivite;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorairesDisponibiliteActiviteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HorairesDisponibiliteActivite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Sélectionner un horaire_id aléatoire
            'horaire_id' => function () {
                // Tente de trouver une horaire existante et utilise son id. Si aucune horaire n'existe, crée une nouvelle horaire et utilise son id.
                return \App\Models\Horaire::inRandomOrder()->first()?->id ?? \App\Models\Horaire::factory()->create()->id;
            },

            // Sélectionner un activite_id aléatoire
            'activite_id' => function () {
                // Tente de trouver une activité existante et utilise son id. Si aucune activité n'existe, crée une nouvelle activité et utilise son id.
                return \App\Models\Activite::inRandomOrder()->first()?->id ?? \App\Models\Activite::factory()->create()->id;
            }
        ];
    }
}
