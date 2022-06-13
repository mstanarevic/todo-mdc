<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
	protected $fillable = ['title', 'description', 'date', 'user_id'];

	/**
	 * Task relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tasks() {
		return $this->hasMany(Task::class);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}
}
