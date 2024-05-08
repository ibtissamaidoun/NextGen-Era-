<?php

namespace Database\Factories;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParentModelFactory extends Factory
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
            'fonction' => $this->faker->word,
            'user_id' => function () {
                // Générez un user_id valide
                return \App\Models\User::factory()->create()->user_id;
            },
        ];
    }
}
