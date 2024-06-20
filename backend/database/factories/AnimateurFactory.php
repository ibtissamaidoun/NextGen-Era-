<?php

namespace Database\Factories;

use App\Models\Animateur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimateurFactory extends Factory
{
    protected $model = Animateur::class;

    public function definition()
    {
        $domaines = ['Art', 'Musique', 'Sport', 'Science', 'Langues', 'Informatique'];

        return [
            'domaine_competence' => $this->faker->randomElement($domaines),
            'user_id' => function () {
                // Créer un utilisateur avec le rôle 'animateur'
                $user = User::factory()->create();
                $user->role = 'animateur';
                $user->save();

                return $user->id;
            },
        ];
    }
}




