<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facture extends Model
{
    use HasFactory;

    protected $fillable = [ 'facture_pdf','devi_id','serie'];


    public function devi(): belongsTo
    {
        return $this->belongsTo(devi::class);
    }

    public function recus(): HasMany
    {
        return $this->hasMany(recu::class );
    }
}
