<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\taskController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\CheckCodeController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\productController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\invoiceController; 

use PharIo\Manifest\Author;

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


//public routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('/tasks',[taskController::class, 'index']);
Route::get('/task/{id}',[taskController::class, 'show']);
Route::get('/task/search/{name}',[taskController::class, 'search']);
Route::post('password/forget', [ForgotPasswordController::class,'forgotPassword'] );
Route::post('password/checkcode', [CheckCodeController::class,'checkCode'] );
Route::post('password/reset', [ResetPasswordController::class,'resetPassword'] );
//protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/task',[taskController::class, 'store']);
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::put('/task/{id}',[taskController::class, 'update']);
    Route::delete('/task/{id}',[taskController::class, 'destroy']);

    /////customer routes////
    Route::get('/customers',[CustomerController::class, 'index']);
    Route::get('/customer/{id}',[CustomerController ::class, 'show']);
    Route::post('/customer',[CustomerController::class, 'store']);
    Route::put('/customer/{id}',[CustomerController::class, 'update']);
    Route::delete('/customer/{id}',[CustomerController::class, 'destroy']);

    //// products routes////
    Route::get('/products',[productController::class, 'index']);
    Route::get('/product/{id}',[productController::class, 'show']);
    Route::post('/product',[productController::class, 'store']);
    Route::put('/product/{id}',[productController::class, 'update']);
    Route::delete('/product/{id}',[productController::class, 'destroy']);

    //// invoice routes////
    Route::get('/invoices',[invoiceController::class, 'index']);
    Route::get('/invoice/{id}',[invoiceController::class, 'show']);
    Route::post('/invoice',[invoiceController::class, 'store']);
    Route::put('/invoice/{id}',[invoiceController::class, 'update']);
    Route::delete('/invoice/{id}',[invoiceController::class, 'destroy']);
    Route::get('/invoice/test/{id}',[invoiceController::class, 'test']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // Route::resource('task', taskController::class);
//     // return $request->user();
// });
// Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);
// // Route::post('task', [taskController::class, 'store']);

// // Route::get('/tasks',[taskController::class, 'index']);
// // Route::post('/addtask',[taskController::class, 'store']);

// Route::resource('task', taskController::class);
// Route::get('/task/search/{name}',[taskController::class, 'search']);