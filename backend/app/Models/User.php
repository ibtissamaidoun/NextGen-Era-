<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    // Les rôles disponibles dans l'application
    const ROLE_ADMIN = 'admin';
    const ROLE_ANIMATEUR = 'animateur';
    const ROLE_PARENT = 'parent';
    
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = ['nom', 'prenom', 'email', 'telephone_portable', 'telephone_fixe', 'photo_path', 'domaine_competence','mot_de_passe','fonction','role'];

    protected $hidden = ['mot_de_passe'];

    public function parentmodel():HasOne
    {
        return $this->HasOne(parentmodel::class);
    }

    public function animateur():HasOne
    {
        return $this->HasOne(animateur::class);

    }

    public function administrateur():HasOne
    {
        return $this->HasOne(administrateur::class);

    }

    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(notification::class, 'user_notification')->withPivot('date_notification','statut');   
    }
}
