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

Route::post('register', 'AccountController@register');
Route::post('authenticate', 'JwtAuthenticateController@authenticate');

Route::group(['middleware' => ['jwt_ability:user']], function() {
    Route::post('todo/create', 'TodoController@store');
});
