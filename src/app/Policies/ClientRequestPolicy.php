<?php

namespace App\Policies;

use App\Models\ClientRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientRequestPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ClientRequest $request)
    {
        return $user->isAdmin() || ($user->isClient() && $request->client_id === $user->client_id);
    }

    public function create(User $user)
    {
        return $user->isClient();
    }

    public function update(User $user, ClientRequest $request)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isClient() 
            && $request->client_id === $user->client_id 
            && $request->status === 'submitted';
    }

    public function delete(User $user, ClientRequest $request)
    {
        return $user->isAdmin();
    }
}
