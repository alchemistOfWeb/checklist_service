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

        // Test roles:
        $this->createRole('Admin')->permissions()->attach([
            $permissions['ban-users'],
            $permissions['limit-user-checklists'],
            $permissions['edit-users'],
            $permissions['create-users'],
            $permissions['delete-users'],
            $permissions['delete-checklists'],
            $permissions['manage-admin-roles'],
        ]);

        $this->createRole('Developer')->permissions()->attach([
            $permissions['create-users'],
            $permissions['edit-users'],
            $permissions['delete-users'],
        ]);
        /////////////////
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
