<?php

namespace App\Policies;

use App\Models\Claim;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User as AuthedUser;

class ClaimPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AuthedUser $authed_user): bool|Response
    {
        return $this->allow(); // $this->deny('Message');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AuthedUser $authed_user, Claim $claim): bool|Response
    {
        return $authed_user->id === $claim->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthedUser $authed_user): bool|Response
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthedUser $authed_user, Claim $claim): bool|Response
    {
        return $authed_user->id === $claim->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthedUser $authed_user, Claim $claim): bool|Response
    {
        return $authed_user->id === $claim->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AuthedUser $authed_user, Claim $claim): bool|Response
    {
        return $authed_user->id === $claim->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AuthedUser $authed_user, Claim $claim): bool|Response
    {
        return $authed_user->id === $claim->user_id;
    }
}
