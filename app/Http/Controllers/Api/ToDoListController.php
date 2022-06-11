<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexToDoRequest;
use App\Http\Requests\CreateToDoListRequest;
use App\Http\Requests\UpdateToDoListRequest;
use App\Models\ToDoList;
use App\Services\ToDoListService;

class ToDoListController extends Controller {

	private $toDoListService;

	public function __construct( ToDoListService $toDoListService ) {
		$this->toDoListService = $toDoListService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index( IndexToDoRequest $request ) {
		$response = $this->toDoListService->index( auth()->user()->id,
			$request->get( 'perPage' ) ?? config('settings.per_page'), $request->get( 'date' ), $request->get( 'title' ) );

		// return response
		return response()->json( $response, $response['status'] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create( CreateToDoListRequest $request ) {
		// get data from request
		$data = $request->only( 'title', 'description', 'date' );
		// process it
		$response = $this->toDoListService->create( $data, auth()->user()->id );

		// return response
		return response()->json( $response, $response['status'] );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\ToDoList $toDoList
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( ToDoList $toDoList ) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateToDoListRequest $request
	 * @param int $toDoListId
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update( UpdateToDoListRequest $request, int $toDoListId ) {
		// get data from request
		$data = $request->only( 'title', 'description', 'date' );
		// process it
		$response = $this->toDoListService->update( $data, $toDoListId, auth()->user() );

		// return response
		return response()->json( $response, $response['status'] );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $toDoList
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete( int $toDoListId ) {
		$response = $this->toDoListService->delete( $toDoListId, auth()->user() );

		return response()->json( $response, $response['status'] );
	}
}
