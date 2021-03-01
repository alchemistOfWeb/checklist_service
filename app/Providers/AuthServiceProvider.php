<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        App\Models\Role::class => App\Policies\RolePolicy::class,
        App\Models\Permission::class => App\Policies\PermissionPolicy::class,
        App\Models\User::class => App\Policies\UserPolicy::class,
        App\Models\Admin::class => App\Policies\AdminPolicy::class,
        App\Models\Checklist::class => App\Policies\ChecklistPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('edit-roles', function($user){
        //     return $user->hasPermissionTo('edit-roles');
        // });
    }
}
