<?php

namespace App\Http\Resources;

use App\Traits\DateTimeConvertTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
	use DateTimeConvertTrait;

	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $this->description,
			'deadline' => $this->maybeConvertToTimezone($this->deadline, auth()->user()->timezone),
			'done' => (bool)$this->done
		];
	}
}
