<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\taskController;
use App\Http\Controllers\API\AuthController;
use App\Http\Resources\Task;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Route::resource('task', taskController::class);
    // return $request->user();
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
// Route::post('task', [taskController::class, 'store']);

// Route::get('/tasks',[taskController::class, 'index']);
// Route::post('/addtask',[taskController::class, 'store']);

Route::resource('task', taskController::class);
Route::get('/task/search/{name}',[taskController::class, 'search']);