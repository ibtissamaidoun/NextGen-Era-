<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreActivite extends Model
{

    use HasFactory;

    protected $table = 'offre_activite';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
}
