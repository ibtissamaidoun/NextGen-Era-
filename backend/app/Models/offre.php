<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offre extends Model
{
    use HasFactory;


    protected $fillable = ['date_fin', 'titre', 'date_debut', 'description', 'remise', 'administrateur_id', 'paiement_id'];


    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(administrateur::class);
    }
    public function demandes(): HasMany
    {
        return $this->hasMany(demande::class);
    }

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(paiement::class);
    }


    public function activites(): BelongsToMany
    {
        return $this->belongsToMany(activite::class, 'offre_activite');
    }
}
