<?php

namespace App\Services;

use App\Http\Resources\ToDoListResource;
use App\Interfaces\ToDoListRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ToDoListService extends BaseService {

	/**
	 * Constructor
	 *
	 * @param ToDoListRepositoryInterface $repository
	 */
	public function __construct( ToDoListRepositoryInterface $repository ) {
		$this->repository = $repository;
	}

	public function index( int $userId, $perPage, $date = null, $title = null ) {
		try {
			$toDoLists = ToDoListResource::collection( $this->repository->index( $userId, $perPage, $date, $title ) );
			$message   = __( 'entity_messages.index', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, $toDoLists );
		} catch ( \Exception $e ) {
			// log error on our server
			Log::error( $e->getMessage() );
			// show error message to user
			$message = __( 'entity_messages.index_error', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

	/**
	 * Create new To Do list
	 *
	 * @param array $data
	 * @param int $currentUserId
	 *
	 * @return mixed
	 */
	public function create( array $data, int $currentUserId ) {
		try {
			// link current user
			$data['user_id'] = $currentUserId;
			// save and return saved to do list
			$createdToDoList = ToDoListResource::make( $this->repository->create( $data ) );
			$message         = __( 'entity_messages.created', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, $createdToDoList );
		} catch ( \Exception $e ) {
			// log error on our server
			Log::error( $e->getMessage() );
			// show error message to usre
			$message = __( 'entity_messages.create_error', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

	/**
	 * Update To Do list
	 *
	 * @param array $data
	 * @param int $toDoListId
	 * @param User $user
	 *
	 * @return array
	 */
	public function update( array $data, int $toDoListId, User $user ) {
		try {

			$updatedToDoList = ToDoListResource::make( $this->repository->update( $toDoListId, $data ) );
			$message         = __( 'entity_messages.updated', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, $updatedToDoList );

		} catch ( ModelNotFoundException ) {
			$message = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 404 );
		} catch ( \Exception $e ) {
			Log::error( $e->getMessage() );
			$message = __( 'entity_messages.update_error', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

	/**
	 *
	 * Delete To Do List
	 *
	 * @param int $toDoListId
	 * @param User $user
	 *
	 * @return array
	 */
	public function delete( int $toDoListId, User $user ) {
		try {

			$this->repository->delete( $toDoListId );
			$message = __( 'entity_messages.deleted', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null );

		} catch ( ModelNotFoundException ) {
			$message = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, 404 );
		} catch ( \Exception $e ) {
			Log::error( $e->getMessage() );
			$message = __( 'entity_messages.delete_error', [ 'entity' => __( 'entities.todolist' ) ] );

			return $this->buildResponse( $message, null, $e->getCode() );
		}
	}
}