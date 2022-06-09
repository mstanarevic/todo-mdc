<?php

namespace App\Policies;

use App\Models\ToDoList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ToDoListPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\ToDoList $toDoList
	 *
	 * @return bool
	 */
	public function view( User $user, ToDoList $toDoList ) {
		return $user->id == $toDoList->user_id;
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\ToDoList $toDoList
	 *
	 * @return bool
	 */
	public function update( User $user, ToDoList $toDoList ) {
		return $user->id == $toDoList->user_id;
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\ToDoList $toDoList
	 *
	 * @return bool
	 */
	public function delete( User $user, ToDoList $toDoList ) {
		return $user->id == $toDoList->user_id;
	}

}
