<?php

namespace App\Policies;

use App\Models\Animateur;
use App\Models\user;
use App\Models\horaire;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\activite;
use App\Models\enfant;

class AnimateurPolicy
{
    use HandlesAuthorization;

    /**
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animateur  $animateur
     * @return bool
     */
    public function manageHeures(User $user, Animateur $animateur)
    {
        // Vérifier si l'utilisateur est bien un animateur et s'il accède à ses propres horaires
        return $user->id === $animateur->user_id;
    }
    public function viewOwnActivities(User $user, Animateur $animateur)
    {

        return $user->id === $animateur->user_id;
    }

}