<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
	public function updateTimezone( int $userId, string $timezone );

	public function getUsersWithTimezones( array $timezones );

	public function getFinishedTasksForDay( array $userIds, string $startTime, string $endTime );
}
