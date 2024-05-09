<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enfant extends Model
{
    use HasFactory;


    protected $fillable = ['nom', 'prenom','age','niveau_etude','parentmodel_id'];
    public function parentmodel():BelongsTo
    {
        return $this->belongsTo(parentmodel::class);
    }

    public function horaires(): BelongsToMany
    {
        return $this->belongsToMany(horaire::class, 'horaires_preferes_enfants');   
    }


    public function activites(): BelongsToMany
    {
        return $this->belongsToMany(activite::class, 'emploi_de_temps');   
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
}