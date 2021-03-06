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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('products', App\Http\Controllers\API\ProductAPIController::class);

Route::resource('purchases', App\Http\Controllers\API\PurchaseAPIController::class);

Route::resource('sales', App\Http\Controllers\API\SaleAPIController::class);

Route::resource('process_templates', App\Http\Controllers\API\ProcessTemplateAPIController::class);

Route::resource('processes', App\Http\Controllers\API\ProcessAPIController::class);

Route::resource('users', App\Http\Controllers\API\UserAPIController::class);