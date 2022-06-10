<?php

namespace App\Http\Middleware;

use App\Interfaces\ToDoListRepositoryInterface;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EnsureUserIsToDoListOwner {
	use ResponseTrait;

	public $repository;

	public function __construct( ToDoListRepositoryInterface $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function handle( Request $request, Closure $next ) {
		try {
			$toDoListId = $request->route()->parameter( 'toDoListId' );
			$toDoList   = $this->repository->findById( $toDoListId );

			if ( ! auth()->user()->can( 'manage', $toDoList ) ) {
				$message  = __( 'entity_messages.manage_gate_error', [ 'entity' => __( 'entities.todolist' ) ] );
				$response = $this->buildResponse( $message, null, 403 );

				return response()->json( $response, $response['status'] );
			}

			return $next( $request );
		} catch ( ModelNotFoundException ) {
			$message  = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.todolist' ) ] );
			$response = $this->buildResponse( $message, null, 404 );

			return response()->json( $response, $response['status'] );

		} catch ( \Exception ) {
			$response = $this->buildResponse( __( 'messages.server_error' ), null, 500 );

			return response()->json( $response, null, $response['status'] );
		}

	}
}
