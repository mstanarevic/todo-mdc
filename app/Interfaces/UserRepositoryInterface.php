<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
	public function updateTimezone(int $userId, string $timezone);
}
