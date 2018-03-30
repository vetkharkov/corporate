<?php

namespace Corp\Policies;

use Corp\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->canDo('ADD_USERS');
    }

    public function edit(User $user)
    {
        return $user->can('EDIT_USERS');
    }

    public function delete(User $user)
    {
        return $user->can('DELETE_USERS');
    }

}
