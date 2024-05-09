<?php

namespace Database\Factories;

use App\Models\Animateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Animateur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domaine_competence' => $this->faker->word,
            'user_id' => function () {
                // Générez un user_id valide
                return \App\Models\User::factory()->create()->user_id;
            },
        ];
    }
}

