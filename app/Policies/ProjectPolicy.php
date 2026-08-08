<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function create(User $user)
    {
        return $user->hasPermissionTo('create projects') || $user->hasPermissionTo('manage projects');
    }

    public function update(User $user, Project $project)
    {
        return $user->hasPermissionTo('edit projects') || $user->hasPermissionTo('manage projects');
    }

    public function delete(User $user, Project $project)
    {
        return $user->hasPermissionTo('delete projects') || $user->hasPermissionTo('manage projects');
    }
}
