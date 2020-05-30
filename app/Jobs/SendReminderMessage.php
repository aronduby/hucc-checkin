<?php

namespace App\Jobs;

use App\Models\Checkin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SendReminderMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $checkin;

    /**
     * Create a new job instance.
     *
     * @param Checkin $checkin
     */
    public function __construct(Checkin $checkin)
    {
        $this->checkin = $checkin;
    }

    /**
     * Execute the job.
     *
     * @param Client $twilio
     * @return void
     */
    public function handle(Client $twilio)
    {
        $message = $twilio->messages
            ->create($this->checkin->phone, [
                'from' => config('twilio.number'),
                'body' => 'Did you forget to checkout? If you already left just respond with OUT and the time you left.'
            ]);

        $this->checkin->reminded = now();
        $this->checkin->save();
    }
}
