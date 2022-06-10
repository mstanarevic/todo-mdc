<?php
namespace App\Repositories;

use App\Interfaces\ToDoListRepositoryInterface;
use App\Models\ToDoList;

class ToDoListRepository extends BaseRepository implements ToDoListRepositoryInterface
{
	/**
	 * ToDoListRepository constructor.
	 * @param ToDoList $toDoList
	 */
	public function __construct(ToDoList $toDoList)
	{
		$this->model = $toDoList;
	}

	/**
	 * Get all to do lists
	 *
	 * @param int $userID
	 * @param int $perPage
	 * @param string|null $date
	 * @param string|null $title
	 *
	 * @return mixed
	 */
	public function index(int $userID, int $perPage, string $date = null, string $title = null) {
		 $toDoLists = $this->model->where('user_id', $userID);

		 if($date) {
			 $toDoLists->whereDate('date', $date);
		 }

		 if($title) {
			 $toDoLists->where('title', 'LIKE', '%'.$title.'%');
		 }

		 return $toDoLists->paginate($perPage);
	}

	/**
	 * Get single to do list by id
	 *
	 * @param $toDoListId
	 *
	 * @return mixed
	 */
	public function findById( $toDoListId ) {
		return $this->model->findOrFail($toDoListId);
	}

	/**
	 * Delete to do list by id
	 *
	 * @param int $toDoListId
	 *
	 * @return mixed
	 */
	public function delete( int $toDoListId ) {
		$toDoList = $this->model->findOrFail($toDoListId);
		return $toDoList->delete();
	}

	/**
	 * Create new to do list
	 *
	 * @param array $toDoListData
	 *
	 * @return mixed
	 */
	public function create( array $toDoListData ) {
		return $this->model->create($toDoListData);
	}

	/**
	 * Update to do list in database
	 *
	 * @param int $toDoListId
	 * @param array $toDoListData
	 *
	 * @return ToDoList|null
	 */
	public function update( int $toDoListId, array $toDoListData ) {
		$toDoList = $this->model->findOrFail($toDoListId);
		return tap($toDoList)->update($toDoListData);
	}
}