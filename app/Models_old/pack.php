<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pack extends Model
{
    use HasFactory;


    protected $fillable = ['type','remise'];


    public function demandes(): HasMany
    {
        return $this->hasMany(demande::class );
    }
}
