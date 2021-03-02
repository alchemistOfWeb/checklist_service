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

    /**
     * @param ...$roles
     * @return bool
     */
    public function hasRole( ...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission)->count();
    }

    /**
     * @param string|Permission $permission_slug
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->first();
        }

        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->slug);
    }

    /**
     * @param Permission $permission
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }
}