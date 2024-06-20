<?php

namespace Database\Factories;

use App\Models\Pack;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pack::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Définir les différentes options pour le champ type
        $types = ['pack_nombre_activites', 'pack_nombre_enfants', 'pack_familial', 'pack_multi_activite'];

        return [
            'type' => $this->faker->randomElement($types),
            'description' => $this->faker->paragraph,
            'remise' => $this->faker->numberBetween(0, 50), // Remise aléatoire entre 0 et 50 %
        ];
    }
}

