<?php

namespace App\Jobs;

use App\Mail\FinishedTasks;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToUsersAboutFinishedTasksJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var array
	 */
	private array $usersWithFinishedTasks;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $usersWithFinishedTasks)
    {
        $this->usersWithFinishedTasks = $usersWithFinishedTasks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    if ($this->batch()->cancelled()) {
		    return;
	    }

	    if(!empty($this->usersWithFinishedTasks)) {
		    // send emails
		    foreach ( $this->usersWithFinishedTasks as $userWithFinishedTask ) {
			    Mail::to( $userWithFinishedTask['email'] )->queue( new FinishedTasks( $userWithFinishedTask['name'], $userWithFinishedTask['tasks_count'] ) );
		    }
	    }
    }
}
