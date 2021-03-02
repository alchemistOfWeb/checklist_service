<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Http\Request;

class AdminService 
{
    public function handleUpdatingRoles(Request $request, $admin) 
    { 
        $admin_current = auth('admin')->user();

        if ( !$admin_current->hasRole('super-admin') ) {
            foreach ($request['roles'] as $key => $value) {
                if ( $admin_current->hasRole(Role::find($value)->slug) ) {
                    continue;
                }
    
                $permissions = Role::find($value)->permissions;
    
                foreach ($permissions as $permission) {
                    if ( !$admin_current->hasPermissionTo($permission) ) {
                        return redirect()->back()->withErrors(['Editing rights is higher than your rights!']);
                    }
                }
            }
        }

        $admin->roles()->detach();
        $admin->roles()->attach($request['roles']);
        
    }
}