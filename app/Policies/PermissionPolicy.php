<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
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
        return Response::deny("This functionality has been limited and any roles or permissions don't help you");
        // return $admin->hasPermissionTo('edit-permissions')
        //     ? Response::allow()
        //     : Response::deny("You don't have permission to manage permissions");
    }
}
