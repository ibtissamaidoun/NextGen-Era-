<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrateur extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function user(): belongsTo
    {
        return $this->belongsTo(user::class);    }

    public function offres(): HasMany
    {
        return $this->hasMany(offre::class);
    }

    public function demandes(): HasMany
    {
        return $this->hasMany(demande::class );
    }

    public function activites(): HasMany
    {
        return $this->hasMany(activite::class );
    }
}
