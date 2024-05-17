<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class animateur extends Model
{
    use HasFactory;
    protected $fillable = ['domaine_competence','user_id'];

    public function user(): belongsTo
    {
        return $this->belongsTo(user::class);  
     }
     

     public function horaires(): BelongsToMany
    {
        return $this->belongsToMany(horaire::class, 'horaires_disponibilite_animateur');   
     }

   // -----------        activite_animateur_horaire         ----------- //
   public function  getHoraires(): BelongsToMany
     {
         return $this->belongsToMany(horaire::class, 'activite_animateur_horaire')
                     ->withPivot('activite_id');
     }

     public function  getActivites(): BelongsToMany
     {
         return $this->belongsToMany(activite::class, 'activite_animateur_horaire')
                     ->withPivot('horaire_id');
     }
}