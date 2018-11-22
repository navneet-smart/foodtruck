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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('user', 'UserController');
Route::get('profile', 'UserController@profile');
Route::get('findUser', 'UserController@search');
Route::put('profile', 'UserController@updateProfile');

Route::apiResource('blogs', 'BlogController');
Route::apiResource('posts', 'PostController');
