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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::prefix('stock')->group(function () {
//    Route::get('/', 'API\StockController@getStock');
//});

Route::get('stock', 'App\Http\Controllers\API\StockController@getStock');

Route::prefix('tracked-stocks')->group(function () {
    Route::get('list', 'App\Http\Controllers\API\TrackedStockController@list');
    Route::get('user-list', 'App\Http\Controllers\API\TrackedStockController@userList');
    Route::post('create', 'App\Http\Controllers\API\TrackedStockController@create');
    Route::get('edit', 'App\Http\Controllers\API\TrackedStockController@edit');
    Route::patch('update', 'App\Http\Controllers\API\TrackedStockController@update');
    Route::delete('delete', 'App\Http\Controllers\API\TrackedStockController@delete');
    Route::post('follow', 'App\Http\Controllers\API\TrackedStockController@follow');
});
