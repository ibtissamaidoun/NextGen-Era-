<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfantDemandeActivite extends Model
{
    use HasFactory;

    protected $table = 'enfant_demande_activite';

    // Disable auto-incrementing ID and primary key handling
    public $incrementing = false;
    protected $primaryKey = ['enfant_id', 'activite_id', 'demande_id'];
    public $timestamps = true;

    // Define the fillable attributes
    protected $fillable = [
        'enfant_id',
        'activite_id',
        'demande_id',
    ];
}
