<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::get()->pluck('id', 'slug');

        $this->createRole('Super admin')->permissions()->attach($permissions->values());

        $this->createRole('Admin')->permissions()->attach([
            $permissions['create-admins'],
            $permissions['edit-admins'],
            $permissions['delete-admins'],
            $permissions['manage-admin-roles'],
            $permissions['manage-admin-permissions'],
            $permissions['ban-users'],
            $permissions['edit-roles'],
        ]);

        $this->createRole('Moderator')->permissions()->attach([
            $permissions['ban-users'],
            $permissions['limit-user-checklists'],
            $permissions['edit-users'],
        ]);

        $this->createRole('Developer')->permissions()->attach([
            $permissions['create-users'],
            $permissions['edit-users'],
            $permissions['delete-users'],
        ]);
    }

    /**
     * help method
     *
     * @param string $str
     * 
     */
    public function createRole($str)
    {
        $manager = new Role();
        $manager->name = $str;
        $manager->slug = Str::slug($str, '-');
        $manager->save();

        return $manager;
    }
}
