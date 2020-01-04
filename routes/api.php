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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api\\'], function () {
    App::setLocale('id');
    /*
     * API MOBILE
     * Auth Route
     * Login / Register / Logout
     */

    Route::post('login', 'AuthAPIController@login');
    Route::post('loginAsDonatur', 'AuthAPIController@loginAsDonatur');
    Route::post('loginAsDriver', 'AuthAPIController@loginAsDriver');
    Route::post('register', 'AuthAPIController@register');
    Route::post('changePassword', 'AuthAPIController@changePassword');
    Route::get('logout', 'AuthAPIController@logout');
    Route::get('getUser', 'AuthAPIController@getUser');

    //Campaign
    Route::group(['prefix' => 'campaign'], function () {
        Route::get('/', 'CampaignAPIController@index');
        Route::get('/getCurrent', 'CampaignAPIController@getCurrent');
        Route::get('/getCategory/{id}', 'CampaignAPIController@getCategory');
        Route::get('/getDetail/{id}', 'CampaignAPIController@show');
    });

    //Donasi
    Route::group(['prefix' => 'donasi'], function () {
        Route::get('/', 'DonasiApiController@index');
        Route::get('/getHistory', 'DonasiApiController@getHistory');
        Route::get('/getHistoryDetail/{id}', 'DonasiApiController@show');
    });
});
