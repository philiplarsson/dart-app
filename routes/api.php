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

Route::group(['prefix' => 'v1', 'middleware' => ['auth.basic']], function () {

    Route::prefix('users')->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::post('/', 'API\UserController@store');
            Route::delete('/{id}', 'API\UserController@destroy');
            /* TODO: updateMultiple() and update() is confusing */
            Route::patch('/', 'API\UserController@updateMultiple');
            Route::patch('/{id}', 'API\UserController@update');
        });

        Route::get('/', 'API\UserController@index');
        Route::get('/{id}', 'API\UserController@show');
        Route::get('/{id}/throws', 'API\UserController@throws');
    });

    Route::prefix('games')->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::delete('/{id}', 'API\GameController@destroy');
        });
        Route::get('/', 'API\GameController@index');
        Route::post('/', 'API\GameController@store');
        Route::get('/{id}', 'API\GameController@show');
        /* TODO: updateMultiple() and update() is confusing */
        Route::patch('/', 'API\GameController@updateMultiple');
        Route::patch('/{id}', 'API\GameController@update');
        Route::get('/{id}/throws', 'API\GameController@throws');
    });

    Route::prefix('gametypes')->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::delete('/{id}', 'API\GameTypeController@destroy');
        });
        Route::get('/', 'API\GameTypeController@index');
        Route::post('/', 'API\GameTypeController@store');
        /* TODO: updateMultiple() and update() is confusing */
        Route::patch('/', 'API\GameTypeController@updateMultiple');
        Route::get('/{id}', 'API\GameTypeController@show');
        Route::patch('/{id}', 'API\GameTypeController@update');
    });

    Route::prefix('throws')->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::patch('/', 'API\CastController@updateMultiple');
            Route::patch('/{id}', 'API\CastController@update');
            Route::delete('/{id}', 'API\CastController@destroy');
        });
        Route::get('/', 'API\CastController@index');
        Route::post('/', 'API\CastController@store');
        /* TODO: updateMultiple() and update() is confusing */
        Route::get('/{id}', 'API\CastController@show');
    });
});
