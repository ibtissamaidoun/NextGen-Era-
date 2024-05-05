<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offre extends Model
{
    use HasFactory;


    protected $fillable = ['date_fin_inscription', 'titre','date_debut_inscription','description','remise','administrateur_id'];


    public function administrateur():BelongsTo
    {
        return $this->belongsTo(administrateur::class);

    }


    // -----------        offre_paiement_activite         ----------- //
    public function getActivites(): BelongsToMany
    {
        return $this->belongsToMany(activite::class, 'offre_paiement_activite')
            ->withPivot(['paiement_id']);   
    }

    public function getPaiements(): BelongsToMany
    {
        return $this->belongsToMany(paiement::class, 'offre_paiement_activite')
            ->withPivot(['activite_id']);   
    }
}