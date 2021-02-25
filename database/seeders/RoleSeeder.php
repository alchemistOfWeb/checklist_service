<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUsers = Permission::where('slug','manage-users')->first();
        $setAdminRights = Permission::where('slug','set-admin-rights')->first();

        // dd(Str::slug('Laravel 5 Framework', '-'));
        $manager = new Role();
        $manager->name = 'Project Manager';
        $manager->slug = 'project-manager';
        $manager->save();
        $manager->permissions()->attach($manageUsers);
        
        $developer = new Role();
        $developer->name = 'Web Dev';
        $developer->slug = 'web-dev';
        $developer->save();
        
        $super = new Role();
        $super->name = 'Super';
        $super->slug = 'super';
        $super->save();
        $super->permissions()->attach($manageUsers);
        $super->permissions()->attach($setAdminRights);
    }
}
