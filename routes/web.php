<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\StringController;
use App\Models\invoice;
use Illuminate\Support\Facades\Auth;

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


Route::get('/viewdata', [ServiceController::class, 'index']);
Route::get('/string', [StringController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('invoices', function () {
//     // $invoices = invoice::get();
//     $invoice = invoice::with(['products'])->first();
//     // dd($invoice);
//     return view('invoices', compact('invoice'));
// });
