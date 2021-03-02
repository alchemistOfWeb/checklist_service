<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Checklist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChecklistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\Admin  $admin_model
     * @return mixed
     */
    public function delete(Admin $admin)
    {
        return $admin->hasPermissionTo('delete-checklists')
            ? Response::allow()
            : Response::deny("You don't have permission to delete checklists");
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\Admin  $admin_model
     * @return mixed
     */
    public function isChecklistOwner(User $user, Checklist $checklist)
    {
        return $user->id == $checklist->user_id
            ? Response::allow()
            : Response::deny("This checklist doesnt belongs to you");
    }
}
