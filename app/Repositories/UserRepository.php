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
}