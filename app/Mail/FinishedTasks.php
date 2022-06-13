<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinishedTasks extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var string
	 */
	private string $name;

	/**
	 * Num of tasks done
	 *
	 * @var int
	 */
	private int $numOfTasksDone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, int $numOfTasksDone)
    {
        $this->name = $name;
		$this->numOfTasksDone = $numOfTasksDone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->subject('ToDo App - Finished tasks!')
	                ->markdown('emails.finished_tasks', [
		                'name' => $this->name,
		                'task_num' => $this->numOfTasksDone
	                ]);
    }
}
