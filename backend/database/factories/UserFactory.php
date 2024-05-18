<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'telephone_portable' => $this->faker->regexify('0[67][0-9]{8}'), // Génère un numéro de téléphone commençant par 06 ou 07 et composé de 10 chiffres
            'telephone_fixe' => $this->faker->optional()->regexify('05[0-9]{8}'),
            'mot_de_passe' => bcrypt('password'), // Vous pouvez utiliser une méthode de hachage appropriée ici
            'role' => $this->faker->randomElement(['parent', 'admin', 'animateur']),
        ];
    }
}
