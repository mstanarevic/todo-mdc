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
		// __( 'entity_messages.view_gate_error', [ 'entity' => __( 'entities.todolist' ) ] ) )
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
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete( User $user, ToDoList $toDoList ) {
		return $user->id == $toDoList->user_id ?
			Response::allow() : Response::deny(
				__( 'entity_messages.delete_gate_error', [ 'entity' => __( 'entities.todolist' ) ] ) );
	}

}
