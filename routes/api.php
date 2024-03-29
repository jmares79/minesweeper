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

Route::post('/game/{rows}/{columns}/{mines}', 'GameController@newGame')->where(['rows' => '[0-9]+', 'columns' => '[0-9]+', 'mines' => '[0-9]+'])->middleware('cors');
Route::get('/game/{id}', 'GameController@getGame')->where(['id' => '[0-9]+']);
Route::post('/save', 'GameController@save');
Route::get('/resume/{id}', 'GameController@resume')->where(['id' => '[0-9]+']);
Route::get('/checkCell/{gridId}/{row}/{column}', 'GridController@checkCell')->where(['gridId' => '[0-9]+', 'row' => '[0-9]+', 'column' => '[0-9]+']);
Route::post('/mark/{gridId}/{row}/{column}', 'GridController@markCell')->where(['row' => '[0-9]+', 'column' => '[0-9]+']);

Route::get('/user/add', 'UserController@add');
Route::get('/users', 'UserController@getAll');
