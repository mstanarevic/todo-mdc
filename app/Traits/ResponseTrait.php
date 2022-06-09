<?php
namespace App\Traits;

trait ResponseTrait {
	public function buildResponse(string $message, $data, $status = 200) {
		return [
			'message' => $message,
			'status' => $status,
			'data' => $data
		];
	}
}