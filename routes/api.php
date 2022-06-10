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

	Route::post('to-do-lists', '\\App\\Http\\Controllers\\Api\\ToDoListController@create');
	Route::get('to-do-lists', '\\App\\Http\\Controllers\\Api\\ToDoListController@index');

	Route::middleware(['to-do-list.owner'])->group(function() {
		Route::put('to-do-lists/{toDoListId}', '\\App\\Http\\Controllers\\Api\\ToDoListController@update');
		Route::delete('to-do-lists/{toDoListId}', '\\App\\Http\\Controllers\\Api\\ToDoListController@delete');
		// tasks
		Route::get('to-do-lists/{toDoListId}/tasks', '\\App\\Http\\Controllers\\Api\\TaskController@index');
	});
});
