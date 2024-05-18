<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horaire extends Model
{
    use HasFactory;

    protected $fillable = ['jour_semaine', 'heure_debut','heure_fin'];


    public function animateurs():BelongsToMany
    {
        return $this->belongsToMany(animateur::class,'horaires_disponibilite_animateur');
    }



    public function activites():BelongsToMany
    {
        return $this->belongsToMany(activite::class,'horaires_disponibilite_activite');
    }


    public function enfants():BelongsToMany
    {
        return $this->belongsToMany(enfant::class,'horaires_preferes_enfants')->withPivot('ordre');
    }

   // -----------        activite_animateur_horaire         ----------- //
    public function getActivites(): BelongsToMany
    {
    return $this->belongsToMany(activite::class, 'activite_animateur_horaire')
                ->withPivot('animateur_id');  
    }

    public function getAnimateurs(): BelongsToMany
    {
    return $this->belongsToMany(animateur::class, 'activite_animateur_horaire')
                ->withPivot('activite_id');  
    }

}