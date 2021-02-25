<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $fields
     * {
     *  name: string,
     *  email: string,
     *  password: string,
     * }
     */
    public static function create($fields)
    {
        $fields['password'] = Hash::make($fields['password']);
        $admin = new static;
        $admin->fill($fields);
        $admin->save();

        foreach ($fields['roles'] as $role_id) {
            $admin->roles()->attach($role_id);
        }

        return $admin;
    }

    /**
     * @param $fields
     * {
     *  name: string,
     *  email: string,
     *  password: string,
     * }
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();

        $this->roles()->detach();
        
        foreach ($fields['roles'] as $role_id) {
            $this->roles()->attach($role_id);
        }
    }

    /**
     * remove the user
     */
    public function remove()
    {
        $this->delete();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admins_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admins_permissions');
    }

    public function hasRole( ...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permission->where('slug', $permission)->count();
    }

    /**
     * @param string $permission_slug
     * @return bool
     */
    public function hasPermissionTo($permission_slug)
    {
        $permission = Permission::where('slug', $permission_slug)->first();
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->slug);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === true) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function deletePermissions(... $permissions) 
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(... $permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}
