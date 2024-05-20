<?php

namespace Database\Factories;

use App\Models\HorairesDisponibiliteAnimateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorairesDisponibiliteAnimateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HorairesDisponibiliteAnimateur::class;

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

            // Sélectionner un animateur_id aléatoire
            'animateur_id' => function () {
                // Tente de trouver une activité existante et utilise son id. Si aucune activité n'existe, crée une nouvelle activité et utilise son id.
                return \App\Models\Animateur::inRandomOrder()->first()?->id ?? \App\Models\Animateur::factory()->create()->id;
            }
        ];
    }
}
