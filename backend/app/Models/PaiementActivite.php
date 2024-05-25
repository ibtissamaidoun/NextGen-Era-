<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementActivite extends Model
{
    use HasFactory;

    protected $table = 'paiement_activite';

    // Indiquer que la clé primaire n'est pas auto-incrémentée
    public $incrementing = false;

    // Définir la clé primaire composite
    protected $primaryKey = ['paiement_id', 'activite_id', 'remise'];

    // Désactiver les timestamps
    public $timestamps = false;

    // Indiquer les attributs remplissables
    protected $fillable = [
        'paiement_id',
        'activite_id',
        'remise',
    ];
}
