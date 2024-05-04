<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activite extends Model
{
    use HasFactory;

    
    protected $fillable = ['titre', 'description','objectifs','image_pub','lien_youtube','type_activite','domaine_activite','fiche_pdf','administrateur_id',
                            'age_max',
                            'age_min',
                            'effectif_max',
                            'effectif_min',
                            'tarif',
                            'effectif_actuel',
                            'nbr_seances_semaine'];


    public function horaires(): BelongsToMany
    {
        return $this->belongsToMany(horaire::class, 'horaires_disponibilite_activite');   
     }


     public function enfants(): BelongsToMany
     {
         return $this->belongsToMany(enfant::class, 'emploi_de_temps');   
      } 

      public function administrateur():BelongsTo
    {
        return $this->belongsTo(administrateur::class);

    }

    // -----------        activite_animateur_horaire         ----------- //
        public function  getAnimateurs(): BelongsToMany
    {
        return $this->belongsToMany(animateur::class, 'activite_animateur_horaire')
                    ->withPivot('horaire_id');   
    }

        public function  getHoraires(): BelongsToMany
    {
        return $this->belongsToMany(horaire::class, 'activite_animateur_horaire')
                    ->withPivot('animateur_id');   
    }
        


        // -----------        enfant_demande_activite         ----------- //
        public function  getDemandes(): BelongsToMany
    {
        return $this->belongsToMany(demande::class, 'enfant_demande_activite')
                    ->withPivot('enfant_id');   
    }
    public function  getEnfants(): BelongsToMany
    {
        return $this->belongsToMany(enfant::class, 'enfant_demande_activite')
                    ->withPivot('demande_id');   
    }


    // -----------        offre_paiement_activite         ----------- //
        public function  getPaiements(): BelongsToMany
    {
        return $this->belongsToMany(paiement::class, 'offre_paiement_activite')
                    ->withPivot(['offre_id']);    
    }
    public function  getOffres(): BelongsToMany
    {
        return $this->belongsToMany(offre::class, 'offre_paiement_activite')
                    ->withPivot(['paiment_id']); 
    }

    }