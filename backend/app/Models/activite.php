<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activite extends Model
{
    use HasFactory;

    protected $table = 'activites';
    protected $fillable = ['titre', 'description','objectifs','image_pub','lien_youtube','type_activite','domaine_activite','fiche_pdf','administrateur_id',
                            'age_max',
                            'age_min',
                            'effectif_max',
                            'effectif_min',
                            'tarif',
                            'effectif_actuel',
                            'nbr_seances_semaine',
                            'date_debut_etud',
                            'date_fin_etud',
                            'status'];


    public function horaires(): BelongsToMany
    {
        return $this->belongsToMany(horaire::class, 'horaires_disponibilite_activite');   
     }


     public function enfants(): BelongsToMany
     {
         return $this->belongsToMany(enfant::class, 'emploi_de_temps')->withPivot('horaire_1','horaire_2');   
      } 

      public function administrateur():BelongsTo
    {
        return $this->belongsTo(administrateur::class);

    }

    public function offres(): BelongsToMany
    {
        return $this->belongsToMany(offre::class, 'offre_activite');   
     }


     public function paiements(): BelongsToMany
  {
         return $this->belongsToMany(paiement::class, 'paiement_activite')
                     ->withPivot('remise');   
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

      // -----------        paniers         ----------- //
      public function  getparentmodels(): BelongsToMany
      {
          return $this->belongsToMany(parentmodel::class, 'paniers')
                      ->withPivot('enfant_id','status');   
      }
      public function  enfantsPanier(): BelongsToMany
      {
          return $this->belongsToMany(enfant::class, 'paniers')
                      ->withPivot('parentmodel_id','status');   
      }
  



}