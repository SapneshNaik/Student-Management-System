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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('login', 'Auth\AuthController@login')->name('login');
Route::post('register', 'Auth\AuthController@register')->name('register');

//Route::group([
//    'middleware' => 'auth:api'
//], function () {
//    Route::get('logout', 'Auth\AdminAuthController@logout')->name('logout');
//    Route::get('user', 'Auth\AdminAuthController@user');
//});


