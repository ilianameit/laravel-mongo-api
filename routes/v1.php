<?php

use Illuminate\Support\Facades\Route;

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

Route::post('login', 'AuthController@login');

Route::get('video/{id}', 'VideoController@show');

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::resource('video', 'VideoController', [
        'only' => ['store', 'update']
    ]);

    Route::put('video/{id}/like', 'VideoController@like');
    Route::delete('video/{id}/like', 'VideoController@unlike');
});


