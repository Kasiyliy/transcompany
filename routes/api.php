<?php

use Illuminate\Http\Request;

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
Route::get('/products', ['as' => 'product.index', 'uses' => 'Api\ItemController@index']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::get('/orders', ['as' => 'order.index', 'uses' => 'Api\OrderController@index']);
    Route::post('/orders/delete/{id}', ['as' => 'order.delete', 'uses' => 'Api\OrderController@delete']);
    Route::post('/orders/accept/{id}', ['as' => 'order.accept', 'uses' => 'Api\OrderController@accept']);
    Route::post('/debtors/all', ['as' => 'debts.sum', 'uses' => 'Api\OrderController@getDebtSum']);

    Route::get('/debtors', ['as' => 'debt.index', 'uses' => 'Api\DebtorController@index']);
});
