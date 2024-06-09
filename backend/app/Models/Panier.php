<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'paniers';

    // Définition des attributs fillables
    protected $fillable = [
        'status',
        'enfant_id',
        'activite_id',
        'parentmodel_id',
    ];

    // Désactiver l'incrémentation automatique de l'ID et la gestion de la clé primaire
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = ['enfant_id', 'activite_id', 'parentmodel_id'];
}
