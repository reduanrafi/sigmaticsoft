<?php

namespace App\Policies;

use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskCommentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, TaskComment $comment)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isClient() 
            && $comment->visibility === 'public' 
            && $comment->task->project->client_id === $user->client_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, TaskComment $comment)
    {
        return $user->isAdmin() || $comment->user_id === $user->id;
    }
}
