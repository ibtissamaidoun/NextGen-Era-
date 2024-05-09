<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    use HasFactory;

    protected $fillable = ['option_paiement'];


    public function demandes(): HasMany
    {
        return $this->hasMany(demande::class );
    }
    

    public function offres(): HasMany
    {
        return $this->hasMany(offre::class );
    }


    public function activites(): BelongsToMany
    {
        return $this->belongsToMany(activite::class, 'paiement_activite')->withPivot('remise');   
     }
    
}
