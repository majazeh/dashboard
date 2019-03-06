<?php

namespace Majazeh\Dashboard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class CloudMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $url, $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $details)
    {
      $this->url = $url;
      $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$client = new \GuzzleHttp\Client(['defaults' => [ 'exceptions' => false ]]);
		$response = $client->post($this->url, [
			\GuzzleHttp\RequestOptions::JSON => $this->details,
			\GuzzleHttp\RequestOptions::HEADERS => [
				'Authorization' => 'KEY='.config('firebase.lck')
			]
		]);
    }
}
