<?php

namespace Database\Factories;

use App\Models\Administrateur;
use App\Models\User; // Ajoutez cette ligne pour importer la classe User
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministrateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Administrateur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                // Créer un utilisateur avec le rôle 'administrateur'
                $user = User::factory()->create();
                $user->role = 'admin';
                $user->save();

                return $user->id;
            },
        ];
    }
}
