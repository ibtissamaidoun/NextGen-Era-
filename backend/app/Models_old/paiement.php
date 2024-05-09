<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    use HasFactory;

    protected $fillable = ['option_paiement','remise'];


    public function demandes(): HasMany
    {
        return $this->hasMany(demande::class );
    }

    // -----------        offre_paiement_activite         ----------- //
    public function getOffres(): BelongsToMany 
    {
      return $this->belongsToMany(offre::class, 'offre_paiement_activite')
                  ->withPivot(['activite_id']);    
    }

    public function getActivitess(): BelongsToMany 
    {
      return $this->belongsToMany(activite::class, 'offre_paiement_activite')
                  ->withPivot(['offre_id']);    
    }
}
