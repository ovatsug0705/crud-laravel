<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('auth/login', '\App\Http\Controllers\Api\AuthController@login')->name('auth');

Route::group(['middleware' => ['apiJwt']], function () {

    Route::post('auth/logout', '\App\Http\Controllers\Api\AuthController@logout')->name('logout');

    Route::get('users', '\App\Http\Controllers\Api\UserController@index')->name('users');

    Route::namespace('Api')
        ->group(function() {
    
        Route::apiResource('tasks', '\App\Http\Controllers\Api\TaskController');
    });
});

