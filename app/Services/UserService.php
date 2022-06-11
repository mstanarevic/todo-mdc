<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UserService extends BaseService {

	public $repository;

	/**
	 * Constructor
	 *
	 * @param UserRepositoryInterface $repository
	 */
	public function __construct( UserRepositoryInterface $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Update current user timezone
	 *
	 * @param string $timezone
	 *
	 * @return array|void
	 */
	public function updateTimezone( string $timezone ) {
		try {
			$this->repository->updateTimezone( auth()->user()->id, $timezone );

			return $this->buildResponse( __( 'timezone_updated' ), $timezone );
		} catch ( ModelNotFoundException ) {
			$message = __( 'entity_messages.not_found', [ 'entity' => __( 'entities.user' ) ] );

			return $this->buildResponse( $message, null, 404 );
		} catch ( \Exception $e ) {
			Log::error( $e->getMessage() );
			$message = __( 'entity_messages.update_error', [ 'entity' => __( 'entities.user' ) ] );

			return $this->buildResponse( $message, null, 500 );
		}
	}

}