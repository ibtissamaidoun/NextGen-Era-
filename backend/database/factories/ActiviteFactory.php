<?php

namespace Database\Factories;
use App\Models\Activite;
use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Sélectionner un administrateur existant aléatoirement
        $administrateurId = Administrateur::inRandomOrder()->first()->id;

        // Générer un statut en fonction de l'effectif actuel et minimum
        $effectifActuel = $this->faker->numberBetween(5, 20);
        $effectifMin = $this->faker->numberBetween(5, 10);
        $status = $effectifActuel > $effectifMin ? 'active' : 'inactive';

        $typesActivite = ['atelier', 'laboratoire'];

        $domaines = ['Art', 'Musique', 'Sport', 'Science', 'Langues', 'Informatique'];


        return [
            'titre' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'objectifs' => $this->faker->paragraph,
            'image_pub' => $this->faker->imageUrl(),
            'fiche_pdf' => $this->faker->url,
            'lien_youtube' => $this->faker->url,
            'nbr_seances_semaine' => $this->faker->randomElement([1, 2]),
            'tarif' => $this->faker->randomFloat(2, 100, 700),
            'effectif_min' => $effectifMin,
            'effectif_max' => $this->faker->numberBetween(20, 50),
            'effectif_actuel' => $effectifActuel,
            'age_min' => $this->faker->numberBetween(5, 12),
            'age_max' => $this->faker->numberBetween(12, 18),
            'status' => $status, // Utilisation du statut généré
            'date_debut_etud' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'date_fin_etud' => $this->faker->dateTimeBetween('+2 months', '+6 months')->format('Y-m-d'),
            'type_activite' => $this->faker->randomElement($typesActivite),
            'domaine_activite' => $this->faker->randomElement($domaines),
            'administrateur_id' => $administrateurId,
        ];
    }
}
