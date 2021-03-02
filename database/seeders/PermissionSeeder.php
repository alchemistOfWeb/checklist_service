<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermission('Edit permissions');
        $this->createPermission('Edit roles');

        $this->createPermission('Create users');
        $this->createPermission('Edit users');
        $this->createPermission('Delete users');
        $this->createPermission('Ban users');
        $this->createPermission('Limit user checklists');

        $this->createPermission('Create admins');
        $this->createPermission('Edit admins');
        $this->createPermission('Delete admins');
        $this->createPermission('Manage admin roles');
        $this->createPermission('Manage admin permissions');

        $this->createPermission('Delete checklists');
    }

    public function createPermission(string $str)
    {
        $createChecklists = new Permission();
        $createChecklists->name = $str;
        $createChecklists->slug = Str::slug($str, '-');
        $createChecklists->save();
    }
}
