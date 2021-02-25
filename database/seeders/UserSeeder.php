<?php

namespace Database\Seeders;

use App\Models\Checklist;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $userFirst = new User();
        // $userFirst->name = 'Jhon';
        // $userFirst->email = 'jhon@deo.com';
        // $userFirst->password = Hash::make('root');
        // $userFirst->limit_of_checklists = 5;
        // $userFirst->save();
        

        // $userSecond = new User();
        // $userSecond->name = 'Thomas';
        // $userSecond->email = 'mike@thomas.com';
        // $userSecond->password = Hash::make('root');
        // $userSecond->save();
        

        // $userThird = new User();
        // $userThird->name = 'noname';
        // $userThird->email = 'no@name.com';
        // $userThird->password = Hash::make('root');
        // $userThird->limit_of_checklists = 1000;
        // $userThird->save();

        foreach (range(1, 50) as $value) {
            $user = User::factory()->create();

            $num_of_checklists = rand(1, $user->limit_of_checklists);
            $user->num_of_checklists = $num_of_checklists;
            $user->save();
            
            Checklist::factory()->count($num_of_checklists)->for($user)->create();
        }
        
    }
}
