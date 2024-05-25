<?php

namespace Database\Factories;

use App\Models\EnfantDemandeActivite;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Enfant;
use App\Models\Activite;
use App\Models\Demande;

class EnfantDemandeActiviteFactory extends Factory
{
    protected $model = EnfantDemandeActivite::class;

    public function definition()
    {
        return [
            'enfant_id' => Enfant::inRandomOrder()->first()?->id ?? Enfant::factory()->create()->id,
            'activite_id' => Activite::inRandomOrder()->first()?->id ?? Activite::factory()->create()->id,
            'demande_id' => Demande::inRandomOrder()->first()?->id ?? Demande::factory()->create()->id,
        ];
    }
}
