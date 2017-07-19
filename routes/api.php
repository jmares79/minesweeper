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

Route::post('/newgame/{rows}/{columns}/{mines}', 'GameController@newGame');
Route::post('/save', 'GameController@save');
Route::get('/resume/{id}', 'GameController@resume');
Route::get('/checkCell/{row}/{column}', 'GridController@checkCell');
Route::post('/mark/{row}/{column}', 'GridController@markCell');
Route::get('/user/add', 'UserController@add');
Route::get('/users', 'UserController@getAll');
