<?php

use App\Http\Controllers\API\ChecklistController;
use App\Http\Controllers\API\LoginController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// login user
Route::post('login', [LoginController::class, 'login'])
    ->name('login');

// register user
Route::post('register', [LoginController::class, 'register'])
    ->name('register');


Route::group(['name' => 'api.', 'middleware' => ['auth:sanctum', 'isbanned']], function(){
    
    // Route::apiResource('users', UserController::class);
    // Route::apiResource('users/{uid}/checklists', ChecklistController::class);

    // get checklist list
    Route::get('users/{uid}/checklists', [ChecklistController::class, 'getChecklists'])
        ->name('checklists.getChecklists');

    // get task list
    Route::get('users/{uid}/checklists/{cid}/tasks', [ChecklistController::class, 'getTasks'])
        ->name('checklists.getTasks');

    // toggle task of checklist
    Route::match(['put', 'patch'], 'users/{uid}/checklists/{cid}/tasks/{tid}/toggle', [ChecklistController::class, 'toggleTask'])
        ->name('checklists.toggleTask');

    // create task in checklist
    Route::post('users/{uid}/checklists/{cid}/tasks', [ChecklistController::class, 'createTask'])
        ->name('checklists.createTask');

    // delete task of checklist
    Route::delete('users/{uid}/checklists/{cid}/tasks/{tid}', [ChecklistController::class, 'destroyTask'])
        ->name('checklists.destroyTask');

    // create checklist
    Route::post('users/{uid}/checklists', [ChecklistController::class, 'createChecklist'])
        ->name('checklists.createChecklist');

    // delete checklist
    Route::delete('users/{uid}/checklists/{cid}', [ChecklistController::class, 'destroyChecklist'])
        ->name('checklists.destroyChecklist');
        
});



// For example
// Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
//     // Some routes ...
//    Route::get('signup', [,''])->name('signup');
//    Route::post('signup', [DashboardController::class, 'index'])->name('signup');
//
// });