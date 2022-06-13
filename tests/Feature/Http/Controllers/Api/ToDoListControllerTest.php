<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToDoListControllerTest extends TestCase {
	use RefreshDatabase;

	private $testListData = [
		'title' => 'TODO list',
		'date' => '2022-06-13',
		'description' => 'Description'
	];

	/**
	 * Test creating to do list
	 * @return void
	 */
	public function test_create_to_do_list() {
		$user = User::factory()->create();
		$response = $this->actingAs( $user )
			->json('POST', 'api/to-do-lists', $this->testListData);
		$response->assertStatus(200);
		$response->assertSimilarJson([
			'message' => 'To Do List was created successfully.',
			'status' => 200,
			'data' => array_merge(['id' => 1], $this->testListData)
		]);
	}
}
