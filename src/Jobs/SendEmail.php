<?php

namespace Majazeh\Dashboard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $display, $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($display, $details)
    {
		$this->display = $display;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$details = $this->details;
		Mail::send($this->display, $this->details, function ($message) use ($details)
		{
			$message->from(env('MAIL_USERNAME'));
            $message->to($details['email']);
            $message->subject($details['title']);
		});
    }
}
