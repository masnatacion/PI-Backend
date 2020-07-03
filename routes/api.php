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

Route::post('/login', 'LoginController@login');


Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('/logout', 'LoginController@logout');

    Route::get('/users', 'UserController@index');
    Route::get('/user/{user}', 'UserController@show');
    Route::post('/user', 'UserController@store');
    Route::put('/user/{user}', 'UserController@update');
    Route::delete('/user/{user}', 'UserController@destroy');

    Route::get('/document/{document}/download', 'DocumentController@download');
    Route::get('/user/{user}/documents', 'DocumentController@index');
    Route::get('/user/{user}/cv', 'DocumentController@cv');
    Route::get('/user/{user}/picture', 'DocumentController@picture');
    Route::get('/document/{id}', 'DocumentController@download');
    Route::post('/user/{user}/picture', 'DocumentController@store_update_picture');
    Route::post('/user/{user}/cv', 'DocumentController@store_update_cv');
    Route::delete('/user/{user}/picture', 'DocumentController@destroy_picture');
    Route::delete('/user/{user}/cv', 'DocumentController@destroy_cv');
});
