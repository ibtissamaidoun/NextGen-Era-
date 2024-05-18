<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enfant extends Model
{
    use HasFactory;


    protected $fillable = ['nom', 'prenom','niveau_etude','parentmodel_id','date_de_naissance'];
    public function parentmodel():BelongsTo
    {
        return $this->belongsTo(parentmodel::class);
    }

    public function horaires(): BelongsToMany
    {
        return $this->belongsToMany(horaire::class, 'horaires_preferes_enfants')->withPivot('ordre');   
    }


    public function activites(): BelongsToMany
    {
        return $this->belongsToMany(activite::class, 'emploi_de_temps')
                    ->withPivot(['horaire_1','horaire_2']);   
     }

   // -----------        enfant_demande_activite         ----------- //
     public function getActivites(): BelongsToMany
     {
         return $this->belongsToMany(activite::class, 'enfant_demande_activite')
                     ->withPivot('demande_id');   
     }

     public function getDemandes(): BelongsToMany
     {
         return $this->belongsToMany(demande::class, 'enfant_demande_activite')
                     ->withPivot('activite_id');   
     }

     // -----------        paniers         ----------- //
     public function activitesPanier(): BelongsToMany
     {
         return $this->belongsToMany(activite::class, 'paniers')
                     ->withPivot('parentmodel_id','status');   
     }

     public function getparentmodels(): BelongsToMany
     {
         return $this->belongsToMany(parentmodel::class, 'paniers')
                     ->withPivot('activite_id','status');   
     }
}
