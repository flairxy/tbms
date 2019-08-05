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

//Route::get('/{any}', 'HomeController@index')->where('any', '.*');

Auth::routes();
Route::post('driver-register', 'AuthController@registerAsDriver')->name('driver-register');

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/driver/create', 'HomeController@registerRef')->name('driverReg');

Route::group(['middleware' => ['auth', 'admin', 'ban']], function () {
    Route::get('management/{any}', 'AdminController@index')->where('any', '.*');
});

Route::group(['middleware'=> ['auth', 'user', 'ban']], function () {
    Route::get('user/{any}', 'UserController@index')->where('any', '.*');
});

Route::group(['middleware'=> ['auth', 'driver', 'ban'], 'prefix'=>'driver'], function () {
    Route::get('{any}', 'DriverController@index')->where('any', '.*');
});
