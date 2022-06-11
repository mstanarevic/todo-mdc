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

Route::post( '/login', '\\App\\Http\\Controllers\\Api\\AuthController@login' );

Route::middleware( [ 'auth:sanctum' ] )->group( function () {

	Route::post( 'to-do-lists', '\\App\\Http\\Controllers\\Api\\ToDoListController@create' );
	Route::get( 'to-do-lists', '\\App\\Http\\Controllers\\Api\\ToDoListController@index' );
	Route::put('/user/update-timezone', '\\App\\Http\\Controllers\\Api\\UserController@updateTimezone' );

	Route::middleware( [ 'to-do-list.owner' ] )->group( function () {
		Route::put( 'to-do-lists/{toDoListId}', '\\App\\Http\\Controllers\\Api\\ToDoListController@update' );
		Route::delete( 'to-do-lists/{toDoListId}', '\\App\\Http\\Controllers\\Api\\ToDoListController@delete' );
		// tasks
		Route::get( 'to-do-lists/{toDoListId}/tasks', '\\App\\Http\\Controllers\\Api\\TaskController@index' );
		Route::post( 'to-do-lists/{toDoListId}/tasks', '\\App\\Http\\Controllers\\Api\\TaskController@create' );
		// ensure that deleting / editing task is in the given list - Maybe overkill?
		Route::middleware( [ 'task-in-to-do-list' ] )->group( function () {
			Route::put( 'to-do-lists/{toDoListId}/tasks/{taskId}', '\\App\\Http\\Controllers\\Api\\TaskController@update' );
			Route::put( 'to-do-lists/{toDoListId}/tasks/{taskId}/toggle-done', '\\App\\Http\\Controllers\\Api\\TaskController@toggleDone' );
			Route::delete( 'to-do-lists/{toDoListId}/tasks/{taskId}', '\\App\\Http\\Controllers\\Api\\TaskController@delete' );
		} );
	} );
} );
