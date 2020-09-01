<?php

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

Route::group(['middleware' => ['guest:api']], function() {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('login/refresh', 'Auth\LoginController@refresh');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('register', 'Auth\RegisterController@register');
});

Route::group(['middleware' => ['jwt']], function() {
    Route::post('lead', 'LeadController@create');
    Route::get('lead/{id}', 'LeadController@show');
    Route::get('leads', 'LeadController@list');
    Route::delete('lead/{id}', 'API\LeadController@destroy');

    Route::post('leaddetail', 'API\LeadDetailController@create');
    Route::put('leaddetail/{id}', 'API\LeadDetailController@update');

    Route::get('phonetype', 'API\PhoneController@getPhoneType');
    Route::post('phone', 'API\PhoneController@create');
    Route::put('phone/{id}', 'API\PhoneController@update');
    Route::delete('phone/{id}', 'API\PhoneController@destroy');

    Route::get('addresstype', 'API\AddressController@getAddressType');
    Route::post('address', 'API\AddressController@create');
    Route::put('address/{id}', 'API\AddressController@update');
    Route::delete('address/{id}', 'API\AddressController@destroy');

    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('me', 'Auth\LoginController@me');
    Route::put('profile', 'ProfileController@update');
});

