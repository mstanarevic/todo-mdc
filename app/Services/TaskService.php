<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\ToDoListRepositoryInterface;
use App\Traits\DateTimeConvertTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class TaskService extends BaseService {

	use DateTimeConvertTrait;

	public $repository;

	public ToDoListRepositoryInterface $toDoListRepository;

	/**
	 * Constructor
	 *
	 * @param TaskRepositoryInterface $repository
	 * @param ToDoListRepositoryInterface $toDoListRepository
	 */
	public function __construct( TaskRepositoryInterface $repository, ToDoListRepositoryInterface $toDoListRepository ) {
		$this->repository         = $repository;
		$this->toDoListRepository = $toDoListRepository;
	}


	public function index( int $toDoListId, int $perPage, bool $done = null, string $deadline = null ) {
		try {
			// convert to server timezone if needed
			if ( ! is_null( $deadline ) ) {
				$deadline = $this->maybeConvertToServerTimezone( $deadline, auth()->user()->timezone );
			}
			$toDoLists = TaskResource::collection( $this->repository->index( $toDoListId, $perPage, $done, $deadline ) );
			$message   = __( 'entity_messages.index', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, $toDoLists );
		} catch ( ModelNotFoundException ) {
			$message = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 404 );
		} catch ( \Exception $e ) {
			// log error on our server
			Log::error( $e->getMessage() .  $e->getTraceAsString() );
			// show error message to usre
			$message = __( 'entity_messages.index_error', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

	/**
	 * Create new task
	 *
	 * @param int $toDoListId
	 * @param array $data
	 *
	 * @return array
	 */
	public function create( int $toDoListId, array $data ) {
		try {
			// link to to do list
			$data['to_do_list_id'] = $toDoListId;

			$createdTask = TaskResource::make( $this->repository->create( $data ) );
			$message     = __( 'entity_messages.created', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, $createdTask );
		} catch ( ModelNotFoundException ) {
			$message = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 404 );
		} catch ( \Exception $e ) {
			// log error on our server
			Log::error( $e->getMessage() );
			// show error message to user
			$message = __( 'entity_messages.create_error', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

	/**
	 * Update task
	 *
	 * @param int $toDoListId
	 * @param int $taskId
	 * @param array $data
	 *
	 * @return array
	 */
	public function update( int $toDoListId, int $taskId, array $data ) {
		try {

			// link to to do list
			$data['to_do_list_id'] = $toDoListId;

			$createdTask = TaskResource::make( $this->repository->update( $taskId, $data ) );
			$message     = __( 'entity_messages.updated', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, $createdTask );
		} catch ( \Exception $e ) {
			// log error on our server
			Log::error( $e->getMessage() );
			// show error message to user
			$message = __( 'entity_messages.update_error', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

	/**
	 * Delete task
	 *
	 * @param int $taskId
	 *
	 * @return array
	 */
	public function delete( int $taskId ) {
		try {

			$this->repository->delete( $taskId );
			$message = __( 'entity_messages.deleted', [ 'entity' => __( 'entities.task' ) ] );

			return $this->buildResponse( $message, null );

		} catch ( \Exception $e ) {
			Log::error( $e->getMessage() );
			$message = __( 'entity_messages.delete_error', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, $e->getCode() );
		}
	}

}