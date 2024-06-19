<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parentmodel extends Model
{
    use HasFactory;
    protected $fillable = ['fonction','user_id'];

    public function user(): belongsTo
    {
        return $this->belongsTo(user::class);
    }
    public function enfants(): HasMany
    {
        return $this->hasMany(enfant::class );
    }

    public function demandes(): HasMany
    {
        return $this->hasMany(demande::class );
    }

    public function devis(): HasMany
    {
        return $this->hasMany(devi::class );
    }

    // -----------        paniers         ----------- //
    public function getEnfants(): BelongsToMany
{
    return $this->belongsToMany(enfant::class, 'paniers')
                ->withPivot('activite_id','status');
}
    public function getActivites(): BelongsToMany
{
    return $this->belongsToMany(activite::class, 'paniers')
                ->withPivot('enfant_id','status');
}

}
