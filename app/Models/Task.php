<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = ['title', 'description', 'to_do_list_id', 'deadline', 'done'];

	/**
	 * ToDo list relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function toDoList() {
		return $this->belongsTo(ToDoList::class);
	}
}
