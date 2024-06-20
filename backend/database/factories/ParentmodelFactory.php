<?php

namespace Database\Factories;

use App\Models\ParentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParentmodelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fonction' => $this->faker->jobTitle,   
               'user_id' => function () {
                // Créer un utilisateur avec le rôle 'parent'
                $user = User::factory()->create();
                $user->role = 'parent';
                $user->save();

                return $user->id;
            },
        ];
    }
}
