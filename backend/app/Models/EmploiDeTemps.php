<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiDeTemps extends Model
{
    use HasFactory;

    protected $table = 'emploi_de_temps';

    // Disable auto-incrementing ID and primary key handling
    public $incrementing = false;
    protected $primaryKey = ['activite_id', 'enfant_id'];
    public $timestamps = true;

    
    // Define the fillable attributes
    protected $fillable = [
        'enfant_id',
        'activite_id',
        'horaire_1',
        'horaire_2',
    ];

}
