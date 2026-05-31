<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->hasPermissionTo('view users');
    }
}
