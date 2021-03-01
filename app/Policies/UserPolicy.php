<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('create-users')
            ? Response::allow()
            : Response::deny("You don't have permission to create users");
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function edit(Admin $admin)
    {
        return $admin->hasPermissionTo('edit-users')
            ? Response::allow()
            : Response::deny("You don't have permission to edit users");
    }

    /**
     * Determine whether the admin can limit num of checklists of the user.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function limitChecklists(Admin $admin)
    {
        return $admin->hasPermissionTo('limit-user-checklists')
            ? Response::allow()
            : Response::deny("You don't have permission to limit user checklists");
    }

    /**
     * Determine whether the admin can ban the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function ban(Admin $admin)
    {
        return $admin->hasPermissionTo('ban-users')
            ? Response::allow()
            : Response::deny("You don't have permission to ban users");
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(Admin $admin)
    {
        return $admin->hasPermissionTo('delete-users')
            ? Response::allow()
            : Response::deny("You don't have permission to delete users");
    }
}
