<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
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
        return $admin->hasPermissionTo('create-admins')
            ? Response::allow()
            : Response::deny("You don't have permission to create admins");
    }

    /**
     * Determine whether the admin can edit the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\Admin  $admin_model
     * @return mixed
     */
    public function edit(Admin $admin)
    {
        return $admin->hasPermissionTo('edit-admins')
            ? Response::allow()
            : Response::deny("You don't have permission to edit admins");
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\Admin  $admin_model
     * @return mixed
     */
    public function update(Admin $admin)
    {
        return $admin->hasAnyPermission('edit-admins', 'manage-admin-roles')
            ? Response::allow()
            : Response::deny("You don't have permission to edit admins");
    }

    /**
     * Determine whether the admin can edit manage admin roles.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\Admin  $admin_model
     * @return mixed
     */
    public function manageRoles(Admin $admin_current, Admin $admin)
    {
        if ( !$admin_current->hasPermissionTo('manage-admin-roles') ) {
            return Response::deny("You don't have permission to manage roles of admins");
        }

        if ( $admin->hasRole('super-admin') && !$admin_current->hasRole('super-admin') ) {
            return Response::deny("You don't have permission to manage roles of this admin");
        }

        return Response::allow();
    }
    
    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\User  $admin_current
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function delete(Admin $admin_current, Admin $admin)
    {
        return 
            $admin_current->hasPermissionTo('delete-admins') 
            && 
            (!$admin->hasRole('super-admin') || $admin_current->id == $admin->id)
            ? Response::allow()
            : Response::deny("You don't have permission to delete admins");
    }
}
