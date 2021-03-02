<?php

use App\Http\Controllers\API\ChecklistController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// login user
Route::post('login', [LoginController::class, 'login'])
    ->name('login');

// register user
Route::post('register', [LoginController::class, 'register'])
    ->name('register');


Route::group(['name' => 'api.', 'middleware' => ['auth:sanctum', 'isbanned']], function(){
    
    // get checklist list
    Route::get('checklists', [ChecklistController::class, 'index'])
        ->name('checklists.index');

    // create checklist
    Route::post('checklists', [ChecklistController::class, 'create'])
        ->name('checklists.createChecklist');

    // delete checklist
    Route::delete('checklists/{cid}', [ChecklistController::class, 'destroy'])
        ->name('checklists.destroyChecklist');

    // get task list
    Route::get('checklists/{cid}/tasks', [TaskController::class, 'index'])
        ->name('tasks.index');

    // toggle task of checklist
    Route::match(['put', 'patch'], 'checklists/{cid}/tasks/{tid}/toggle', [TaskController::class, 'toggleStatus'])
        ->name('tasks.toggleStatus');

    // create task in checklist
    Route::post('checklists/{cid}/tasks', [TaskController::class, 'create'])
        ->name('tasks.create');

    // delete task of checklist
    Route::delete('checklists/{cid}/tasks/{tid}', [TaskController::class, 'destroy'])
        ->name('checklists.destroyTask');
        
});