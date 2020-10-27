<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskListController;
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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //task lists functions
    Route::get('/lists', [TaskListController::class, 'index']);
    Route::post('/lists', [TaskListController::class, 'store']);
    Route::patch('/lists/{taskList}', [TaskListController::class, 'update']);
    Route::delete('/lists/{taskList}', [TaskListController::class, 'destroy']);
    Route::patch('/lists/mark-close/{taskList}', [TaskListController::class, 'edit']);
});
