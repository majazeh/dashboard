<?php

namespace Majazeh\Dashboard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use \App\FirebaseToken;
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
        $body = json_decode($response->getBody()->getContents());
        if($body && isset($body->results) && is_array($body->results))
        {
            $delete_tokens = [];
            foreach ($body->results as $key => $value) {
                if(isset($value->error) && $value->error == 'NotRegistered')
                {
                    $ids = isset($this->details['to']) ? $this->details['to'] : $this->details['registration_ids'];
                    $delete_tokens[] = $ids[$key];
                }
            }
            FirebaseToken::whereIn('token', $delete_tokens)->delete();
        }
    }
}
