<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserTimezoneRequest;
use App\Services\UserService;

class UserController extends Controller {

	private $userService;

	public function __construct( UserService $userService ) {
		$this->userService = $userService;
	}

	/**
	 * Update users timezone
	 *
	 * @param UpdateUserTimezoneRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateTimezone( UpdateUserTimezoneRequest $request ) {
		// get data from request
		$timezone = $request->get( 'timezone' );

		$response = $this->userService->updateTimezone( $timezone );

		// return response
		return response()->json( $response, $response['status'] );
	}
}
