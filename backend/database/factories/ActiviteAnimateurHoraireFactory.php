<?php

namespace Database\Factories;

use App\Models\ActiviteAnimateurHoraire;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Animateur;
use App\Models\HorairesDisponibiliteActivite;

class ActiviteAnimateurHoraireFactory extends Factory
{
    protected $model = ActiviteAnimateurHoraire::class;

    public function definition()
    {
        // Sélectionner un couple horaire_id et activite_id valide
        $disponibilite = HorairesDisponibiliteActivite::inRandomOrder()->first()  ?? HorairesDisponibiliteActivite::factory()->create();

        return [
            'animateur_id' => Animateur::inRandomOrder()->first()?->id ?? Animateur::factory()->create()->id,
            'activite_id' => $disponibilite->activite_id,
            'horaire_id' => $disponibilite->horaire_id,
        ];
    }
}
