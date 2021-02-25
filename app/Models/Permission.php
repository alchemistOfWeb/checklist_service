<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    protected $table = "permissions";

    protected $fillable = ['name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    public static function create($fields)
    {
        $permission = new static;
        $permission->name = $fields['name'];
        $permission->slug = Str::slug($fields['name'], '-');
        $permission->save();
    }

    public function edit($fields)
    {
        $this->name = $fields['name'];
        $this->slug = Str::slug($fields['name'], '-');
        $this->save();
    }
}
