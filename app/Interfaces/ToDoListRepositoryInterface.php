<?php

namespace App\Interfaces;

use App\Models\ToDoList;

interface ToDoListRepositoryInterface
{
	public function index(int $userID, int $perPage, string $date = null, string $title = null);
	public function findById($toDoListId);
	public function delete(int $toDoListId);
	public function create(array $toDoListData);
	public function update(int $toDoListId, array $toDoListData);
}
