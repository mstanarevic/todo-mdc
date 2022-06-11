<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller {

	private $taskService;

	public function __construct( TaskService $taskService ) {
		$this->taskService = $taskService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @param int $toDoListId
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index( IndexTaskRequest $request, int $toDoListId ) {
		$response = $this->taskService->index( $toDoListId,
			$request->get( 'perPage' ) ?? config( 'settings.per_page' ),
			$request->get( 'done' ), $request->get( 'deadline' ) );

		// return response
		return response()->json( $response, $response['status'] );
	}

	/**
	 * Create task
	 *
	 * @param CreateTaskRequest $request
	 * @param int $toDoListId
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create( CreateTaskRequest $request, int $toDoListId ) {
		// get data from request
		$data = $request->only( 'title', 'description', 'deadline' );

		$response = $this->taskService->create($toDoListId, $data );

		// return response
		return response()->json( $response, $response['status'] );
	}

	/**
	 * Display the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function read( Request $request, int $taskId ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\UpdateTaskRequest $request
	 * @param int $toDoListId
	 * @param int $taskId
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update( UpdateTaskRequest $request, int $toDoListId, int $taskId ) {
		// get data from request
		$data = $request->only( 'title', 'description', 'deadline' );

		$response = $this->taskService->update( $toDoListId, $taskId, $data );

		// return response
		return response()->json( $response, $response['status'] );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param int $toDoListId
	 * @param int $taskId
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete( Request $request, int $toDoListId, int $taskId ) {
		$response = $this->taskService->delete( $taskId );

		// return response
		return response()->json( $response, $response['status'] );
	}
}
