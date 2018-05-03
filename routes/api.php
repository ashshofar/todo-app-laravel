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

Route::group(['middleware' => ['ability:user']], function() {
    
    Route::group(['prefix' => 'todo'], function(){
        Route::get('get', 'TodoController@get');
        Route::get('show/{id}', 'TodoController@show');
        Route::post('store', 'TodoController@store');
    
        //if you try patch via postman, you must use x-www-url-form-urlencoded
        Route::patch('patch/{id}', 'TodoController@patch');
    
        //update todo via POST method
        Route::post('update/{id}', 'TodoController@patch');
    
        Route::delete('delete/{id}', 'TodoController@destroy');
    });

});
