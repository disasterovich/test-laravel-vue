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

//List (including search)
Route::get('books', 'BookController@index');

//Single
Route::get('books/{id}', 'BookController@show');

//Create new
Route::post('books', 'BookController@store');

//Update
Route::put('books', 'BookController@store');

//Delete
Route::delete('books/{id}', 'BookController@destroy');