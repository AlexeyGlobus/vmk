<?php

namespace App\Policies;

use App\Models\AccessRight;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AccessRightPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('read-access_rights')
            ? Response::allow()
            : Response::deny('Log in required');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccessRight  $accessRight
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AccessRight $accessRight)
    {
        return $user->can('read-access_rights')
            ? Response::allow()
            : Response::deny(__('Log in required'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-access_rights')
            ? Response::allow()
            : Response::deny(__('Only authorized user can do this'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccessRight  $accessRight
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AccessRight $accessRight)
    {
        return $user->can('update-access_rights')
            ? Response::allow()
            : Response::deny(__('Only authorized user can do this'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccessRight  $accessRight
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AccessRight $accessRight)
    {
        return $user->can('delete-access_rights')
            ? Response::allow()
            : Response::deny(__('Only authorized user can do this'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccessRight  $accessRight
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AccessRight $accessRight)
    {
        return $user->can('update-access_rights')
            ? Response::allow()
            : Response::deny(__('Only authorized user can do this'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccessRight  $accessRight
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AccessRight $accessRight)
    {
        return $user->can('delete-access_rights')
            ? Response::allow()
            : Response::deny(__('Only authorized user can do )this'));
    }
}
