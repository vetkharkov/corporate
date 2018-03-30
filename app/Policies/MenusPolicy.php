<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenusPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function save(User $user)
    {
        return $user->canDo('EDIT_MENU');
    }
}
