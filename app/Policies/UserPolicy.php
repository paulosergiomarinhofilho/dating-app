<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $authUser, User $userBeingEdited)
    {   
        // Verifique se o usuário autenticado é o mesmo que está sendo editado.
        return $authUser->id === $userBeingEdited->id || $authUser->isAdmin;
    }
}
