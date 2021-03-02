<?php

namespace Database\Seeders;

use App\Models\Checklist;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 40) as $value) {
            $user = User::factory()->create();

            $num_of_checklists = rand(1, $user->limit_of_checklists);
            $user->num_of_checklists = $num_of_checklists;
            $user->save();
            
            $checklists = Checklist::factory()->count($num_of_checklists)->for($user)->create();

            $num_of_tasks = rand(2, 20);

            foreach ($checklists as &$checklist) {
                Task::factory()->count($num_of_tasks)->for($checklist)->create();
            }
        }
        
        $user = new User;
        $user->name = 'Roger Zelazny';
        $user->email = 'user@supermail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('root');
        $user->limit_of_checklists = 5;
        $user->remember_token = Str::random(10);
        $user->save();
    }
}
