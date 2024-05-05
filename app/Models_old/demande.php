<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demande extends Model
{
    use HasFactory;

    protected $fillable = ['date_traitement','statut','motif_refus','paiement_id','administrateur_id','pack_id','parentmodel_id'];


    public function parentmodel():BelongsTo
    {
        return $this->belongsTo(parentmodel::class);
    }

    public function pack():BelongsTo
    {
        return $this->belongsTo(pack::class);
    }

    public function administrateur():BelongsTo
    {
        return $this->belongsTo(administrateur::class);
    }

    public function paiement():BelongsTo
    {
        return $this->belongsTo(paiement::class);
    }

   // -----------        enfant_demande_activite         ----------- //
    public function getEnfants(): BelongsToMany
{
    return $this->belongsToMany(enfant::class, 'enfant_demande_activite')
                ->withPivot('activite_id');   
}
    public function getActvites(): BelongsToMany
{
    return $this->belongsToMany(activite::class, 'enfant_demande_activite')
                ->withPivot('enfant_id');   
}


}