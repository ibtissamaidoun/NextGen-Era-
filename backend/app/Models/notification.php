<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;


    protected $fillable = ['type','statut','contenu'];
    
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(user::class, 'user_notification')->withPivot('date_notification','statut');   
    }
}
