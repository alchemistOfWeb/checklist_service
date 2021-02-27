<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory(20)->create();

        $super = Role::where('slug', 'super-admin')->first();

        $admin = new Admin();
        $admin->name = 'Super Admin';
        $admin->email = 'super@supermail.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make('root');
        $admin->save();
        $admin->roles()->attach($super);
    }
}
