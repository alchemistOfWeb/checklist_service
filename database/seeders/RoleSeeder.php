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

        // $manageUsers = Permission::where('slug', 'Edit permissions')->first();

        // $f = Permission::where('slug', 'Edit roles')->first();

        // $manageUsers = Permission::where('slug', 'Create users')->first();
        // $manageUsers = Permission::where('slug', 'Edit users')->first();
        // $manageUsers = Permission::where('slug', 'Deleting users')->first();
        // $manageUsers = Permission::where('slug', 'Banning users')->first();
        // $manageUsers = Permission::where('slug', 'Limiting user checklists')->first();

        // $manageUsers = Permission::where('slug', 'Create admins')->first();
        // $manageUsers = Permission::where('slug', 'Edit admins')->first();
        // $manageUsers = Permission::where('slug', 'Deleting admins')->first();
        // $manageUsers = Permission::where('slug', 'Manage admin roles')->first();
        // $manageUsers = Permission::where('slug', 'Manage admin permissions')->first();



        // dd(Str::slug('Laravel 5 Framework', '-'));
        $this->createRole('Super admin')->permissions()->attach($permissions->values());

        $this->createRole('Admin')->permissions()->attach([
            $permissions['create-admins'],
            $permissions['edit-admins'],
            $permissions['deleting-admins'],
            $permissions['manage-admin-roles'],
            $permissions['manage-admin-permissions'],
            $permissions['banning-users'],
            $permissions['edit-roles'],
        ]);

        $this->createRole('Moderator')->permissions()->attach([
            $permissions['banning-users'],
            $permissions['limiting-user-checklists'],
            $permissions['edit-users'],
        ]);

        $this->createRole('Developer')->permissions()->attach([
            $permissions['create-users'],
            $permissions['edit-users'],
            $permissions['deleting-users'],
        ]);


        // $manager = new Role();
        // $manager->name = 'Project Manager';
        // $manager->slug = 'project-manager';
        // $manager->save();
        // $manager->permissions()->attach($manageUsers);
        
        // $developer = new Role();
        // $developer->name = 'Web Dev';
        // $developer->slug = 'web-dev';
        // $developer->save();
        
        // $super = new Role();
        // $super->name = 'Super';
        // $super->slug = 'super';
        // $super->save();
        // $super->permissions()->attach($manageUsers);
        // $super->permissions()->attach($setAdminRights);
    }

    public function createRole($str)
    {
        $manager = new Role();
        $manager->name = $str;
        $manager->slug = Str::slug($str, '-');
        $manager->save();

        return $manager;
    }
}
