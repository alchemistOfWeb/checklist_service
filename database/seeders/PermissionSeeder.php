<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUser = new Permission();
        $manageUser->name = 'Manage users';
        $manageUser->slug = 'manage-users';
        $manageUser->save();

        $createChecklists = new Permission();
        $createChecklists->name = 'Set admin rights';
        $createChecklists->slug = 'set-admin-rights';
        $createChecklists->save();
    }
}
