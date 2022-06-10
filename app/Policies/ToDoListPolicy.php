<?php

namespace App\Policies;

use App\Models\ToDoList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToDoListPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can manage to do list
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\ToDoList $toDoList
	 *
	 * @return bool
	 */
	public function manage( User $user, ToDoList $toDoList ) {
		return $user->id == $toDoList->user_id;
	}
}
