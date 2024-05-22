<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiviteAnimateurHoraire extends Model
{
    use HasFactory;

    protected $table = 'activite_animateur_horaire';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['animateur_id', 'activite_id', 'horaire_id'];
}
