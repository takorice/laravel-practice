<?php

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

// Public Routes
Route::post('login', [\App\Http\Controllers\LoginController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\LoginController::class, 'logout']);

    Route::apiResource('tasks', \App\Http\Controllers\TaskController::class);
    // Route::put('tasks/update_status/{task}', [\App\Http\Controllers\TaskController::class, 'updateStatus']);
    Route::put('tasks/update_done/{task}', [\App\Http\Controllers\TaskController::class, 'updateDone']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});
