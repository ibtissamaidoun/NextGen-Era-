<?php

namespace Database\Factories;

use App\Models\PaiementActivite;
use App\Models\Paiement;
use App\Models\Activite;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementActiviteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaiementActivite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Sélectionner un paiement existant aléatoirement
        $paiementId = Paiement::inRandomOrder()->first()->id;

        // Sélectionner une activité existante aléatoirement
        $activiteId = Activite::inRandomOrder()->first()->id;

        return [
            'paiement_id' => $paiementId,
            'activite_id' => $activiteId,
            'remise' => $this->faker->numberBetween(0, 50), // Remise aléatoire entre 0 et 50
        ];
    }
}
