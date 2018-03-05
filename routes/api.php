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

Route::prefix('v1')->group(function () {

    Route::prefix('users')->group(function () {
        // Route::middleware('auth:api')->get('/user', function (Request $request) {
        //     return $request->user();
        // });
        Route::get('/', 'API\UserController@index');
        Route::post('/', 'API\UserController@store');
        Route::get('/{id}', 'API\UserController@show');
        Route::patch('/{id}', 'API\UserController@update');
        Route::delete('/{id}', 'API\UserController@destroy');
    });

    Route::prefix('games')->group(function () {
        Route::get('/', 'API\GameController@index');
        Route::post('/', 'API\GameController@store');
        Route::get('/{id}', 'API\GameController@show');
        Route::patch('/{id}', 'API\GameController@update');
        Route::delete('/{id}', 'API\GameController@destroy');
    });

    Route::prefix('gametypes')->group(function () {
        Route::get('/', 'API\GameTypeController@index');
        Route::post('/', 'API\GameTypeController@store');
        Route::get('/{id}', 'API\GameTypeController@show');
        Route::patch('/{id}', 'API\GameTypeController@update');
        Route::delete('/{id}', 'API\GameTypeController@destroy');
    });

    Route::prefix('throws')->group(function () {
        Route::get('/', 'API\CastController@index');
        Route::post('/', 'API\CastController@store');
        Route::get('/{id}', 'API\CastController@show');
        Route::patch('/{id}', 'API\CastController@update');
        Route::delete('/{id}', 'API\CastController@destroy');
    });
});
