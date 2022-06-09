<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Traits\ResponseTrait;

abstract class BaseService
{
	use ResponseTrait;

	/**
	 * @var Repository
	 */
	protected $repository;

	/**
	 * BaseRepository constructor.
	 * @param BaseRepository $repository
	 */
	public function __construct(BaseRepository $repository)
	{
		$this->repository = $repository;
	}
}