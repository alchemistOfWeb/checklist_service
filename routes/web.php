<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChecklistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'admin'], function(){

    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.showLoginForm');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout')->withoutMiddleware('guest');
    });
    
    Route::group(['middleware' => 'admin'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('/admins', AdminController::class);
    
        Route::resource('/users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus'); // bun or unban user
        Route::resource('/users/{user}/checklists', ChecklistController::class);
    
        Route::resource('/permissions', PermissionController::class);
    
        Route::resource('/roles', RoleController::class);
    });
});


