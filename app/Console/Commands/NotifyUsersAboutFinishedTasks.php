<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailToUsersAboutFinishedTasksJob;
use App\Services\UserService;
use App\Traits\DateTimeHelperTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class NotifyUsersAboutFinishedTasks extends Command
{
	use DateTimeHelperTrait;

	private UserService $userService;

	public function __construct(UserService $userService) {
		$this->userService = $userService;
		parent::__construct();
	}

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users {--datetime=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users of tasks done on current day';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 * @throws \Throwable
	 */
    public function handle()
    {
		// allow calling this command from command line and passing custom date
	    $dateTime = $this->option('datetime');

	    if(is_null($dateTime)) {
			$dateTime = Carbon::now()->format(config('settings.datetime_format'));
	    }

	    $zones = $this->getMidnightTimeZones($dateTime);

		if(!empty($zones)) {
			$finishedTasks = $this->userService->getUsersFinishedTasks($zones);
			$jobs = [];
			$jobs = array_merge($jobs,
				$finishedTasks->chunk(config('settings.job_batch_size'))->map(
					function ($dataChunk)  {
						return new SendEmailToUsersAboutFinishedTasksJob($dataChunk->toArray());
					})->toArray());

			Bus::batch($jobs)
			   ->allowFailures()
			   ->name("Notify Users about finished tasks for dateTime:#{$dateTime} ")->dispatch();
		}
    }
}
