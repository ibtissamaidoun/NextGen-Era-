<?php

namespace Database\Factories;

use App\Models\Horaire;
use App\Models\EmploiDeTemps;
use App\Models\Enfant;
use App\Models\Activite;
use App\Models\HorairesDisponibiliteActivite;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmploiDeTempsFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = EmploiDeTemps::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        $activite = Activite::inRandomOrder()->first() ?? Activite::factory()->create();
        
        $horaires = HorairesDisponibiliteActivite::where('activite_id', $activite->id)->get();
        
        if ($horaires->isEmpty()) {
            $horaire1 = Horaire::factory()->create();
            HorairesDisponibiliteActivite::create(['activite_id' => $activite->id, 'horaire_id' => $horaire1->id]);
            $horaire2 = $this->faker->boolean ? Horaire::factory()->create() : null;
            if ($horaire2) {
                HorairesDisponibiliteActivite::create(['activite_id' => $activite->id, 'horaire_id' => $horaire2->id]);
            }
        } else {
            $horaire1 = $horaires->random()->horaire_id;
            $horaire2 = $this->faker->boolean ? $horaires->where('horaire_id', '!=', $horaire1)->random()->horaire_id : null;
        }

        return [
            'enfant_id' => Enfant::inRandomOrder()->first()?->id ?? Enfant::factory()->create()->id,
            'activite_id' => $activite->id,
            'horaire_1' => $horaire1,
            'horaire_2' => $horaire2,
        ];
    }
}
