<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/', function(){
    return redirect()->route('login');
});

Route::group(['middleware'=>'auth'], function(){
    Route::get('/home', ['as' => 'home' , 'uses' => 'HomeController@index']);

    Route::group(['middleware' => 'admin'], function(){

        Route::get('/users', ['as' => 'user.index' , 'uses' => 'UserController@index']);
        Route::get('/users/create', ['as' => 'user.create' , 'uses' => 'UserController@create']);
        Route::post('/users/store', ['as' => 'user.store' , 'uses' => 'UserController@store']);
        Route::get('/users/edit/{id}', ['as' => 'user.edit' , 'uses' => 'UserController@edit'])->where('id', '[0-9]+');
        Route::post('/users/update/{id}', ['as' => 'user.update' , 'uses' => 'UserController@update'])->where('id', '[0-9]+');
        Route::post('/users/updatePassword/{id}', ['as' => 'user.updatePassword' , 'uses' => 'UserController@updatePassword'])->where('id', '[0-9]+');
        Route::post('/users/delete/{id}', ['as' => 'user.delete' , 'uses' => 'UserController@delete'])->where('id', '[0-9]+');

        Route::get('/vehicles/create', ['as' => 'vehicle.create' , 'uses' => 'VehicleController@create']);
        Route::post('/vehicles/store', ['as' => 'vehicle.store' , 'uses' => 'VehicleController@store']);
        Route::get('/vehicles', ['as' => 'vehicle.index' , 'uses' => 'VehicleController@index']);
        Route::get('/vehicles/edit/{id}', ['as' => 'vehicle.edit' , 'uses' => 'VehicleController@edit'])->where('id', '[0-9]+');
        Route::post('/vehicles/update/{id}', ['as' => 'vehicle.update' , 'uses' => 'VehicleController@update'])->where('id', '[0-9]+');
        Route::post('/vehicles/delete/{id}', ['as' => 'vehicle.delete' , 'uses' => 'VehicleController@delete'])->where('id', '[0-9]+');

        Route::get('/roles', ['as' => 'role.index' , 'uses' => 'RoleController@index']);
        Route::get('/roles/edit/{id}', ['as' => 'role.edit' , 'uses' => 'RoleController@edit'])->where('id', '[0-9]+');
        Route::post('/roles/update/{id}', ['as' => 'role.update' , 'uses' => 'RoleController@update'])->where('id', '[0-9]+');

    });

    Route::get('/user/edit', ['as' => 'self.user.edit' , 'uses' => 'UserController@selfEdit']);
    Route::post('/user/update', ['as' => 'self.user.update' , 'uses' => 'UserController@selfUpdate']);
    Route::post('/user/updatePassword', ['as' => 'self.user.updatePassword' , 'uses' => 'UserController@selfUpdatePassword']);


});
