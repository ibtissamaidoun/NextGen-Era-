<?php

namespace Database\Factories;

use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Paiement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Options de paiement disponibles
        $optionsPaiement = ['mensuel', 'trimestriel', 'semestriel', 'annuel'];

        return [
            'option_paiement' => $this->faker->randomElement($optionsPaiement),
        ];
    }
}

