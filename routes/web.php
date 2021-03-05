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

Route::resource('users', App\Http\Controllers\UserController::class);

Route::get('stockMovements.index', 'App\Http\Controllers\StockMovementController@index')->name('stockMovements.index');

Route::get('customers.index', 'App\Http\Controllers\UserController@indexCustomers')->name('customers.index');
Route::get('customers.create', 'App\Http\Controllers\UserController@create')->name('customers.create');
Route::post('customers.store', 'App\Http\Controllers\UserController@storeCustomer')->name('customers.store');
Route::get('customers.edit/{id}', 'App\Http\Controllers\UserController@edit')->name('customers.edit');
Route::patch('customers.update/{id}', 'App\Http\Controllers\UserController@updateCustomer')->name('customers.update');
