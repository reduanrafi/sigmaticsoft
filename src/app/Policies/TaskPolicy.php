<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isClient() 
            && $task->client_visible 
            && $task->project->client_id === $user->client_id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Task $task)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Task $task)
    {
        return $user->isAdmin();
    }

    public function addComment(User $user, Task $task)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isClient() 
            && $task->client_visible 
            && $task->project->client_id === $user->client_id;
    }
}
