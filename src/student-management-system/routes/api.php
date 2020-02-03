<?php

use App\Constants;

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
    //Non Auth routes
    Route::post('login', 'Auth\AuthController@login')
        ->name('login')->middleware('can_login');


    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        //only authenticated users can register admin/staff/students,
        Route::post('register', 'Auth\AuthController@register')
            ->name('register')
            ->middleware('permission:'
                .Constants::PERMISSIONS['REGISTER_STAFF'].'|'
                .Constants::PERMISSIONS['REGISTER_STUDENT'].'|'
                .Constants::PERMISSIONS['REGISTER_ADMIN'].'');

        Route::get('logout', 'Auth\AuthController@logout')->name('logout');

        //User Routes

        Route::get('/user', '\App\Http\Controllers\UserController@profile')
            ->name('user.profile');

        Route::get('/users', '\App\Http\Controllers\UserController@index')
            ->name('users.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_USERS'].'');

        Route::get('/users/{user}', '\App\Http\Controllers\UserController@show')
            ->name('users.show')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_USERS'].'');

        //TODO: Add check for own profile or edit all user perm in controller
        Route::put('/users/{user}', '\App\Http\Controllers\UserController@update')
            ->name('users.update');

        Route::delete('/users/{user}', '\App\Http\Controllers\UserController@delete')
            ->name('users.delete')
            ->middleware('permission:'.Constants::PERMISSIONS['DELETE_ALL_USERS'].'');

    });



});




