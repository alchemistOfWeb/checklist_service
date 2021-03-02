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

    public function edit($fields)
    {
        $this->name = $fields['name'];
        $this->slug = Str::slug($fields['name'], '-');
        $this->save();
        
        $this->permissions()->detach();

        foreach ($fields['permissions'] as $permission_id) {
            $this->permissions()->attach($permission_id);
        }
        
    }
}
