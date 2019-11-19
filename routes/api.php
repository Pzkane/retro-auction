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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group( function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'jwt.refresh'], function(){
        Route::get('refresh', 'AuthController@refresh');
    });

    Route::group(['middleware' => 'jwt.auth'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });

    // Route::group(['middleware' => 'auth:api'], function () {
    //     Route::get('user', 'AuthController@user');
    //     Route::post('logout', 'AuthController@logout');
    // });
});

Route::group(['middleware' => 'auth:api'], function () {
    //Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{email}', 'UserController@show')->middleware('isAdminOrSelf');
});

Route::get('/offers', 'OfferController@index');   
