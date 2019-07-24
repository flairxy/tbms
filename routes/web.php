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

Auth::routes(['verify' => true]);

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invite/join/{name}', 'HomeController@registerRef');

Route::group(['middleware' => ['auth', 'admin', 'ban']], function () {
    Route::get('management/{any}', 'AdminController@index')->where('any', '.*');
});

Route::group(['middleware'=> ['auth', 'user', 'ban', 'verified']], function () {
    Route::get('{any}', 'UserController@index')->where('any', '.*');
});

Route::group(['namespace' => 'API/User'], function () {
    Route::post('/crypto/payment/status', 'UserDepositsController@cryptoStatus')->name('userDepositCrypto');
});
