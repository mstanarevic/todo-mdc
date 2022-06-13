<?php

namespace App\Interfaces;

interface TaskRepositoryInterface {
	public function index( int $toDoListId, int $perPage, bool $done = null, string $deadline = null );

	public function findById( $taskId );

	public function delete( int $taskId );

	public function create( array $taskData );

	public function update( int $taskId, array $taskData );
}
