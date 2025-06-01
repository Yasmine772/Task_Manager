<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {

    Route::post('profile', [ProfileController::class, 'store']);

    Route::get('user/{id}/profile', [UserController::class, 'getProfile']);
    Route::get('user/{id}/tasks', [UserController::class, 'getUserTasks']);



    Route::apiResource('tasks', TaskController::class);
    Route::get('task/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUser');
    Route::get('task/{id}/user', [TaskController::class, 'getTaskUser']);
    Route::post('task/{taskId}/categories', [TaskController::class, 'addCategoriesToTask']);
    Route::get('task/{taskId}/categories', [TaskController::class, 'getTaskCategory']);

});
