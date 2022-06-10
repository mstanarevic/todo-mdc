<?php

namespace App\Http\Middleware;

use App\Interfaces\TaskRepositoryInterface;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnsureTaskIsInCorrectToDoList
{
	use ResponseTrait;

	public $repository;

	public function __construct( TaskRepositoryInterface $repository ) {
		$this->repository = $repository;
	}

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\JsonResponse
	 */
    public function handle(Request $request, Closure $next)
    {
	    try {
		    $taskId = $request->route()->parameter( 'taskId' );
		    $toDoListId = $request->route()->parameter( 'toDoListId' );
		    $task = $this->repository->findById( $taskId );
		    // check if the task id exists and if the user tried somehow to update task that
		    // is not in given to do list
		    // TODO maybe this is not really mandatory - a bit overkill
		    if ( $task->to_do_list_id != $toDoListId ) {
			    $response = $this->buildResponse( __( 'entity_messages.task_not_in_to_do_list_error' ), null, 422 );
				return response()->json($response, $response['status']);
		    }
		    return $next( $request );
	    } catch ( ModelNotFoundException ) {
		    $message  = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.task' ) ] );
		    $response = $this->buildResponse( $message, null, 404 );

		    return response()->json( $response, $response['status'] );

	    } catch ( \Exception ) {
		    $response = $this->buildResponse( __( 'messages.server_error' ), null, 500 );

		    return response()->json( $response, null, $response['status'] );
	    }
    }
}
