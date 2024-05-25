<?php

namespace Database\Factories;

use App\Models\Horaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class HoraireFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Horaire::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Générer une heure de début aléatoire
        $heureDebut = $this->faker->time('H:i');

        // Générer une heure de fin aléatoire qui est au maximum 3 heures après l'heure de début
        $heureFin = $this->faker->time('H:i', strtotime($heureDebut . ' + 3 hours'));

        return [
            'jour_semaine' => $this->faker->randomElement(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']),
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
        ];
    }
}
