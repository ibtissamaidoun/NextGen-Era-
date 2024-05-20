<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorairesDisponibiliteActivite extends Model
{
    use HasFactory;

    protected $table = 'horaires_disponibilite_activite';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
}
