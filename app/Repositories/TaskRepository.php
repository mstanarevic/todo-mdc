<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface {
	/**
	 * TaskRepository constructor.
	 *
	 * @param Task $task
	 */
	public function __construct( Task $task ) {
		$this->model = $task;
	}

	/**
	 * Get all tasks
	 *
	 * @param int $toDoListId
	 * @param int $perPage
	 * @param bool|null $done
	 * @param string|null $deadline
	 *
	 * @return mixed
	 */
	public function index( int $toDoListId, int $perPage, bool $done = null, string $deadline = null ) {
		$tasks = $this->model->where( 'to_do_list_id', $toDoListId );

		if ( ! is_null( $done ) ) {
			$tasks->where( 'done', $done );
		}

		if ( $deadline ) {
			$tasks->where( 'deadline', '<=', $deadline );
		}

		return $tasks->paginate( $perPage );
	}

	/**
	 * Get single task by id
	 *
	 * @param $taskId
	 *
	 * @return mixed
	 */
	public function findById( $taskId ) {
		return $this->model->findOrFail( $taskId );
	}

	/**
	 * Delete task by id
	 *
	 * @param int $taskId
	 *
	 * @return mixed
	 */
	public function delete( int $taskId ) {
		$toDoList = $this->model->findOrFail( $taskId );

		return $toDoList->delete();
	}

	/**
	 * Create new task
	 *
	 * @param array $taskData
	 *
	 * @return mixed
	 */
	public function create( array $taskData ) {
		return $this->model->create( $taskData );
	}

	/**
	 * Update task
	 *
	 * @param int $taskId
	 * @param array $taskData
	 *
	 * @return Task|null
	 */
	public function update( int $taskId, array $taskData ) {
		$task = $this->model->findOrFail( $taskId );

		return tap( $task )->update( $taskData );
	}
}