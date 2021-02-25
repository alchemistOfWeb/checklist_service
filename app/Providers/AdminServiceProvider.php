<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
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
        Blade::directive('admin_name', function () {
            return "<?= Auth::guard('admin')->user()->name ?>";
        });
        Blade::directive('admin_email', function () {
            return "<?= Auth::guard('admin')->user()->email ?>";
        });
        Blade::directive('admin_roles', function () {
            return "<?= Auth::guard('admin')->user()->roles->implode('name', ', ') ?>";
        });
    }
}
