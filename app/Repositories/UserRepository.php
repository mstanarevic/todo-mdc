<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
	/**
	 * TaskRepository constructor.
	 *
	 * @param User $user
	 */
	public function __construct( User $user ) {
		$this->model = $user;
	}

	/**
	 * Update user timezone
	 *
	 * @param int $userId
	 * @param string $timezone
	 *
	 * @return mixed
	 */
	public function updateTimezone( int $userId, string $timezone ) {
		$user           = $this->model->findOrFail( $userId );
		$user->timezone = $timezone;

		return $user->save();
	}

	/**
	 * Get all users that have timezones set
	 *
	 * @param array $timezones
	 *
	 * @return mixed
	 */
	public function getUsersWithTimezones( array $timezones ) {
		return $this->model->select( 'id' )->whereIn( 'timezone', $timezones )->get();
	}

	/**
	 * Get users finished tasks for selected day
	 *
	 * @param array $userIds
	 * @param string $startTime
	 * @param string $endTime
	 *
	 * @return mixed
	 */
	public function getFinishedTasksForDay( array $userIds, string $startTime, string $endTime ) {
		return $this->model->whereIn( 'id', $userIds )->with( [
			'toDoLists' => function ( $q ) use ( $startTime, $endTime ) {
				$q->withCount( [
					'tasks' => function ( $q ) use ( $startTime, $endTime ) {
						$q->where( 'done', 1 )
						  ->where( 'done_at', '>=', $startTime )
						  ->where( 'done_at', '<=', $endTime );
					}
				] );
			}
		] )->get();
	}
}