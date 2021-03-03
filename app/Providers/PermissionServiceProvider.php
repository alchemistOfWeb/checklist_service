<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('haspermission', function (...$permissions) {
            $permissions = implode(', ', $permissions);

            return "<?php 
                if ( Auth::guard('admin')->user()->hasAnyPermission($permissions) )  
            { ?>";
        });
        
        Blade::directive('nopermission', function ($permission) {
            return "<?php if ( !(Auth::guard('admin')->user()->hasPermissionTo($permission)) )  { ?>";
        });

        Blade::directive('elsepermission', function ($permission) {
            return "<?php } else { ?>";
        });

        Blade::directive('elseifpermission', function ($permission) {
            return "<?php } elseif ( Auth::guard('admin')->user()->hasPermissionTo($permission) ) { ?>";
        });

        Blade::directive('endpermission', function ($permission) {
            return "<?php } ?>";
        });
    }
}
