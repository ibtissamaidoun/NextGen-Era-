<?php

namespace App\Policies;

use App\Models\activite;
use App\Models\enfant;
use App\Models\user;
use Illuminate\Auth\Access\Response;

class ActivitePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function view(User $user, Activite $activite)
    {
        return $activite->animateurs->contains('user_id', $user->id);
    }
    public function viewStudent(User $user, Activite $activite, Enfant $enfant)
{
    // Vérifier que l'activité contient cet enfant
    $hasStudent = $activite->enfants->contains($enfant->id);

    // Vérifier que l'animateur de l'utilisateur est lié à l'activité
    $isHisActivity = $activite->animateurs->contains($user->animateur->id);

    return $hasStudent && $isHisActivity;
}

    
}
