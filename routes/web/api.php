<?php

//Auth::routes();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::group(['as' => 'api.', 'namespace' => 'API'], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return Auth::user();
    });
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:api'], function () {
        Route::group(['as' => '.admin', 'prefix' => 'admin'], function () {
            Route::get('/users/total-drivers', ['uses' => 'AdminUsersController@totalDrivers']);
            Route::get('/users/total-riders', ['uses' => 'AdminUsersController@totalRiders']);
            Route::get('/users/all-rides', ['uses' => 'AdminRideController@allRides']);
            Route::get('/rides/payments', ['uses' => 'AdminPaymentController@allPayments']);
            Route::get('/rides/transactions', ['uses' => 'AdminPaymentController@transactions']);
            Route::post('/settings/{id}/delete', ['uses' => 'AdminPaymentController@deleteSettings']);
            Route::post('/settings/create', ['uses' => 'AdminPaymentController@settingsCreate']);

            Route::group(['as' => '.user', 'prefix' => 'user'], function () {
                Route::get('/users', ['uses' => 'AdminUsersController@users']);
                Route::get('/drivers', ['uses' => 'AdminUsersController@drivers']);
                Route::get('/{id}/driver', ['uses' => 'AdminUsersController@driver']);
                Route::post('/{id}/delete', ['uses' => 'AdminUsersController@delete']);
                Route::post('/driver/{id}/delete', ['uses' => 'AdminUsersController@deleteDriver']);
                Route::post('/{id}/status', ['uses' => 'AdminUsersController@status']);
                Route::post('/driver/{id}/status', ['uses' => 'AdminUsersController@driverStatus']);

            });
        });
    });

    //User Routes
    Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
        Route::post('/book/ride', ['uses' => 'RideController@create']);
        Route::post('/rate-ride', ['uses' => 'RideController@rateRide']);
        Route::post('/ride/{id}/cancel', ['uses' => 'RideController@cancelRide']);
        Route::post('/ride/{id}/complete', ['uses' => 'RideController@completeRide']);

        Route::get('/drivers', ['uses' => 'UsersController@drivers']);
        Route::get('/driver/{id}', ['uses' => 'UsersController@driver']);
        Route::get('/rides/{id}', ['uses' => 'UsersController@rides']);
        Route::get('/driver/rides/{id}', ['uses' => 'UsersController@driverRides']);
        Route::post('/driver/availability/{id}', ['uses' => 'UsersController@availability']);
        Route::post('/driver/update/{id}', ['uses' => 'UsersController@updateDriver']);
        Route::get('/driver/{id}/total-rides', ['uses' => 'UsersController@driverTotalRides']);
        Route::get('/driver/{id}/pending-rides', ['uses' => 'UsersController@pendingRides']);
    });

});
