<?php

namespace Database\Factories;

use App\Models\Facture;
use App\Models\Devi;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Facture::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $deviId = Devi::inRandomOrder()->first()->id;
        
        return [
            'facture_pdf' => $this->faker->word . '.pdf',
            'devi_id' => $deviId,
        ];
    }
}
