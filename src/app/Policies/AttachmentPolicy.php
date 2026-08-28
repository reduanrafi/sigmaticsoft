<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;
use App\Models\Task;
use App\Models\ClientRequest;
use App\Models\TaskComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Attachment $attachment)
    {
        if ($user->isAdmin()) {
            return true;
        }

        $parent = $attachment->attachable;
        if (!$parent) {
            return false;
        }

        if ($parent instanceof Task) {
            $taskPolicy = new TaskPolicy();
            return $taskPolicy->view($user, $parent);
        }

        if ($parent instanceof ClientRequest) {
            $requestPolicy = new ClientRequestPolicy();
            return $requestPolicy->view($user, $parent);
        }

        if ($parent instanceof TaskComment) {
            $commentPolicy = new TaskCommentPolicy();
            return $commentPolicy->view($user, $parent);
        }

        return false;
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Attachment $attachment)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $attachment->uploaded_by === $user->id;
    }
}
