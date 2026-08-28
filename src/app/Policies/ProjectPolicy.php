<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        return $user->isAdmin() || ($user->isClient() && $project->client_id === $user->client_id);
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Project $project)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Project $project)
    {
        return $user->isAdmin();
    }
}
