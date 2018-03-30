<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function change(User $user) {
        //EDIT_PERMISSIONS
        return $user->canDo('EDIT_USERS');
    }
}
