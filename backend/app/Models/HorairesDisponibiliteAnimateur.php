<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorairesDisponibiliteAnimateur extends Model
{
    use HasFactory;

    protected $table = 'horaires_disponibilite_animateur';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
}
