<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
	use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {
		$user = User::factory()->create();
        $response = $this->json('POST','/api/auth/login', [
			'email' => $user->email,
	        'password' => 'password' // default pw
        ]);

        $response->assertStatus(200);
    }

	/**
	 * Test login has validation errors
	 *
	 * @return void
	 */
	public function test_login_required_data()
	{
		$response = $this->json('POST','/api/auth/login');
		$response->assertStatus(422);
		$response->assertJsonValidationErrors(['email', 'password']);
	}

	/**
	 * Test wrong credentials
	 *
	 * @return void
	 */
	public function test_wrong_login_credentials()
	{
		$response = $this->json('POST','/api/auth/login', [
			'email' => 'non_existing@email.com',
			'password' => 'wrong_password'
		]);
		$response->assertStatus(401);
		$response->assertExactJson(['message' => 'Invalid login credentials']);
	}
}
