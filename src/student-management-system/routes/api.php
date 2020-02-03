<?php

use App\Constants;
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
    //TODO: Custom middleware to preevnt login from non-admissioned students
    Route::post('login', 'Auth\AuthController@login')->name('login');


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
        Route::get('profile', 'Auth\AuthController@profile')->name('profile');
    });
});




