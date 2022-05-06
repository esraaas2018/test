<?php

use App\Http\Controllers\PersonalTaskController;
use App\Http\Controllers\UserController;
use App\Models\PersonalTask;
use App\Models\Project;
use App\Models\Task;
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
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'],
    function () {
        Route::get('/logout', [UserController::class, 'logout']);
        Route::apiResource('personal_tasks', "PersonalTaskController");
        Route::group(['middleware' => 'authorized:'.Project::class.'|'.PersonalTask::class], function () {
            Route::apiResource('personal_tasks', "PersonalTaskController")->except('index', 'store');
            Route::apiResource('projects', "ProjectController")->except('index', 'store');

        });
    });
