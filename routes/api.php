<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;

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


Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //task lists functions
    Route::get('/lists', [TaskListController::class, 'index']);
    Route::get('/lists/export-pdf', [TaskListController::class, 'indexExportPdf']);
    Route::get('/lists/deadline', [TaskController::class, 'taskDeadline']);
    Route::post('/lists/list-sorting', [TaskListController::class, 'listSorting']);
    Route::post('/lists/list-filtering', [TaskListController::class, 'listFiltering']);

    Route::middleware(['can:view,taskList'])->group(function () {
        Route::get('/lists/{taskList}', [TaskListController::class, 'show']);
        Route::get('/lists/{taskList}/export-pdf', [TaskListController::class, 'taskListExportPdf']);
    });
    Route::post('/lists', [TaskListController::class, 'store']);

    Route::middleware(['can:update,taskList'])->group(function () {
        Route::patch('/lists/{taskList}', [TaskListController::class, 'update']);
        Route::patch('/lists/mark-close/{taskList}', [TaskListController::class, 'edit']);
    });
    Route::delete('/lists/{taskList}', [TaskListController::class, 'destroy'])
        ->middleware('can:delete,taskList');


    //tasks functions
    Route::middleware(['can:create,taskList'])->group(function () {
        Route::post('/lists/{taskList}', [TaskController::class, 'store']);
        Route::post('/lists/create-list/{taskList}', [TaskListController::class, 'store']);
        Route::post('/lists/{taskList}/task-sorting', [TaskListController::class, 'taskSorting']);
    });
    Route::middleware(['checkList', 'can:view,taskList'])->group(function () {
        Route::get('/lists/{taskList}/{task}', [TaskController::class, 'show']);
        Route::patch('/lists/{taskList}/{task}', [TaskController::class, 'update']);
        Route::patch('/lists/{taskList}/mark-done/{task}', [TaskController::class, 'edit']);
        Route::delete('/lists/{taskList}/{task}', [TaskController::class, 'destroy']);
    });
});
