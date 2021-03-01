<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can edit models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function manage(Admin $admin)
    {
        return $admin->hasPermissionTo('edit-roles')
            ? Response::allow()
            : Response::deny("You don't have permission to manage roles");
    }
}
