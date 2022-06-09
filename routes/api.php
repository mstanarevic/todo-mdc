<?php

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

Route::post('/login', '\\App\\Http\\Controllers\\Api\\AuthController@login');

Route::middleware(['auth:sanctum'])->group(function () {
	// to do lists
	Route::get('to-do-lists', '\\App\\Http\\Controllers\\Api\\ToDoListController@index');
	Route::post('to-do-lists', '\\App\\Http\\Controllers\\Api\\ToDoListController@create');
	Route::put('to-do-lists/{id}', '\\App\\Http\\Controllers\\Api\\ToDoListController@update');
	Route::delete('to-do-lists/{id}', '\\App\\Http\\Controllers\\Api\\ToDoListController@delete');
});
