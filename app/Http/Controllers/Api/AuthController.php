<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
	/**
	 * Login user and return access token on success
	 *
	 * @param LoginRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(LoginRequest $request) {
		if (!Auth::attempt($request->only('email', 'password'))) {
			return response()->json([
				'message' => 'Invalid login credentials'
			], 401);
		}

		$user = User::where('email', $request->get('email'))->firstOrFail();
		$token = $user->createToken('auth_token')->plainTextToken;
		return response()->json([
			'access_token' => $token,
			'token_type' => 'Bearer',
		]);
	}
}
