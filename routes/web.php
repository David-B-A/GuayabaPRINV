<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', [
    HomeController::class, 'index'
])->name('home');

Auth::routes();

Route::get('/home', [
    HomeController::class, 'index'
])->name('home');


Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('purchases', App\Http\Controllers\PurchaseController::class);

Route::resource('sales', App\Http\Controllers\SaleController::class);

Route::resource('processTemplates', App\Http\Controllers\ProcessTemplateController::class);

Route::resource('processes', App\Http\Controllers\ProcessController::class);