<?php

namespace App\Policies;

use App\Models\Horaire;
use App\Models\user;
use Illuminate\Auth\Access\Response;

class HorairePolicy
{
    public function update(User $user, Horaire $horaire)
{
    return $user->animateur->horaires->contains($horaire);
}

public function delete(User $user, Horaire $horaire)
{
    return $user->animateur->horaires->contains($horaire);
}

}
