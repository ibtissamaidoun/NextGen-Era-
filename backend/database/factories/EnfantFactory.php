<?php

namespace Database\Factories;

use App\Models\Enfant;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EnfantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enfant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $niveauxEtude = ['Primaire', 'College', 'Lycee'];

        // Génération d'une date de naissance aléatoire pour une personne âgée de 6 à 17 ans
        $dateNaissance = Carbon::now()->subYears(rand(6, 16))->subDays(rand(0, 365));

        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'date_de_naissance' => $dateNaissance->format('Y-m-d'), // Formatage de la date pour correspondre au format attendu
            'niveau_etude' => $this->faker->randomElement($niveauxEtude),
            'parentmodel_id' => function () {
                // Sélectionner un parentmodel existant aléatoirement
                return ParentModel::inRandomOrder()->first()->id;
            },
        ];
    }
}
