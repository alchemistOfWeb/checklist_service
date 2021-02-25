<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public static function create($fields)
    {
        $role = new static;
        $role->name = $fields['name'];
        $role->slug = Str::slug($fields['name'], '-');
        $role->save();

        foreach ($fields['permissions'] as $permission_id) {
            $role->permissions()->attach($permission_id);
        }
    }

    public function hasPermissionId($permission_id)
    {

    }

    public function edit($fields)
    {
        $this->name = $fields['name'];
        $this->slug = Str::slug($fields['name'], '-');
        $this->save();
        
        // What way is more faster?

        // ------FIRST WAY---------------------------------------
        // I think this way is more faster but I may mistake
        $this->permissions()->detach();
        foreach ($fields['permissions'] as $permission_id) {
            $this->permissions()->attach($permission_id);
        }
        //-------------------------------------------------------

        // ------SECOND WAY--------------------------------------
        // foreach ($this->permissions as $permission) {
        //     if (!in_array($permission->id, $fields['permissions'])) {
        //         $this->permissions()->detach($permission);
        //     }     
        // }

        // foreach ($fields['permissions'] as $permission_id) {
        //     if (!$this->permissions->contains('id', $permission_id)) {
        //         $this->permissions()->attach($permission_id);
        //     }
        // }
        //--------------------------------------------------------

    }
}
