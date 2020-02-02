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

Route::group([
    'prefix' => 'v1'
], function(){
    Route::post('login', 'Auth\AuthController@login')->name('login');


    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        //only authenticated users can register users, ex Admin/Staff with the right role
        Route::post('register', 'Auth\AuthController@register')->name('register');
        Route::get('logout', 'Auth\AdminAuthController@logout')->name('logout');
        Route::get('user', 'Auth\AdminAuthController@user');
    });
});




