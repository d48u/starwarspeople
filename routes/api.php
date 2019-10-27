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

Route::group(['prefix' => 'v1','namespace' => 'API'], function(){
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'RegisterController@login');

    Route::middleware('auth:api')->group( function () {
        // uncomment when index of all people is required
        // Route::get('people', 'PeopleController@index');
        Route::post('people/person', 'PeopleController@show');
    });
});

