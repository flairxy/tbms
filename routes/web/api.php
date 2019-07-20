<?php

//Admin Routes
use Illuminate\Http\Request;
//Auth::routes();
Route::group(['as' => 'api.', 'namespace' => 'API'], function () {
//    Route::post('register', ['uses' => 'AuthController@register']);
//    Route::post('login', ['uses' => 'AuthController@login']);
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
//    Admin Routes
    Route::group(['namespace' => 'Admin', 'middleware'=> 'auth:api'], function () {
        Route::group(['as' => '.admin', 'prefix'=>'admin'], function () {
            Route::get('deposits', ['as' => '.edit', 'uses' => 'AdminUsersController@deposits']);

            Route::group(['as' => '.user', 'prefix'=>'user'], function () {
                Route::get('/', ['as' => '.view', 'uses' => 'AdminUsersController@index']);
                Route::post('create', ['as' => '.create', 'uses' => 'AdminUsersController@create']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminUsersController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminUsersController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminUsersController@delete']);

                Route::group(['prefix'=>'deposit'], function () {
                    Route::get('/', ['uses' => 'UserDepositController@index']);
                    Route::post('delete/{id}', ['uses' => 'UserDepositController@delete']);

                });
                Route::group(['prefix'=>'withdrawal'], function () {
                    Route::get('/', ['as' => '.index', 'uses' => 'UserWithdrawalController@index']);
                    Route::post('delete/{id}', ['uses' => 'UserWithdrawalController@delete']);

                });

            });

            Route::group(['as' => '.email', 'prefix'=>'email'], function () {
                Route::post('create', ['as' => '.create', 'uses' => 'AdminEmailsController@create']);
            });

            Route::group(['as' => '.payment', 'prefix'=>'payment'], function () {
                Route::get('create', ['as' => '.create', 'uses' => 'AdminPaymentController@create']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminPaymentController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminPaymentController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminPaymentController@delete']);
            });

            Route::group(['as' => '.plan', 'prefix' => 'plan'], function () {
                Route::get('/', ['as' => '.view', 'uses' => 'AdminPlansController@index']);
//                Route::get('/{id}', ['as' => '.view', 'uses' => 'AdminPlansController@plan']);
                Route::get('/styles', ['uses' => 'AdminPlansController@styles']);
                Route::post('create', ['as' => '.create', 'uses' => 'AdminPlansController@create']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminPlansController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminPlansController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminPlansController@delete']);
            });

            Route::group(['prefix' => 'gateway', 'middleware'=> 'auth:api'], function () {
                Route::get('/', ['as' => '.view', 'uses' => 'AdminGatewayController@index']);
                Route::post('create', ['as' => '.create', 'uses' => 'AdminGatewayController@create']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminGatewayController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminGatewayController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminGatewayController@delete']);
            });

            Route::group(['prefix' => 'referral'], function () {
                Route::get('/', ['as' => '.view', 'uses' => 'AdminReferralController@index']);
                Route::get('/{id}/users', ['uses' => 'AdminReferralController@getUserReferrals']);
                Route::post('create', ['as' => '.create', 'uses' => 'AdminReferralController@create']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminReferralController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminReferralController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminReferralController@delete']);
            });

            Route::group(['as' => '.investment', 'prefix'=> 'investment'], function () {
                Route::get('create', ['as' => '.create', 'uses' => 'AdminInvestmentController@create']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminInvestmentController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminInvestmentController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminInvestmentController@delete']);
            });

            Route::group(['as' => '.settings', 'prefix' => 'settings'], function () {
                Route::post('create', ['as' => '.create', 'uses' => 'AdminSettingsController@create']);
                Route::get('/', ['uses' => 'AdminSettingsController@index']);
                Route::get('/rate', ['uses' => 'AdminSettingsController@rate']);
                Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'AdminSettingsController@edit']);
                Route::post('update/{id}', ['as' => '.update', 'uses' => 'AdminSettingsController@update']);
                Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'AdminSettingsController@delete']);
            });


        });
    });

    //User Routes
    Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {

        Route::group(['as' => '.investment', 'prefix' => 'investment'], function () {
            Route::post('create', ['as' => '.create', 'uses' => 'UserInvestmentController@create']);
            Route::get('user/{id}', ['uses' => 'UserInvestmentController@index']);
        });

        Route::group(['as' => '.deposit', 'prefix' => 'deposit', 'middleware'=> 'auth:api'], function () {
            Route::post('create', ['uses' => 'UserDepositController@create']);
            Route::get('index/{id}', ['uses' => 'UserDepositController@index']);
            Route::post('exchange', ['uses' => 'UserDepositController@exchange']);
        });

        Route::group(['as' => '.withdrawal',  'prefix' => 'withdrawal', 'middleware'=> 'auth:api'], function () {
            Route::post('create', ['uses' => 'UserWithdrawalController@create']);
            Route::get('index/{id}', ['uses' => 'UserWithdrawalController@index']);
            Route::post('delete/{id}', ['as' => '.delete', 'uses' => 'UserWithdrawalController@delete']);
        });


        Route::group(['as' => '.profile',  'prefix' => 'profile'], function () {
            Route::get('{id}/accounts', ['uses' => 'UserProfileController@balance']);
            Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'UserProfileController@edit']);
            Route::post('update/{id}', ['as' => '.update', 'uses' => 'UserProfileController@update']);
        });
    });

});
