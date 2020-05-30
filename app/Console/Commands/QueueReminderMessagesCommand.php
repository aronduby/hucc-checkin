<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderMessage;
use App\Models\Checkin;
use Illuminate\Console\Command;

class QueueReminderMessagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkin:queue-reminders {range=3 : Hours back to check, no value does everyone }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queues the jobs to send the reminder messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $range = $this->argument('range');

        $query = Checkin::open();
        if ($range != 0) {
            $newest = time() - ($range * 60 * 60);
            $oldest = $newest - (60 * 60);

            $newest = date("Y-m-d H:i:s", $newest);
            $oldest = date("Y-m-d H:i:s", $oldest);

            $query->whereBetween('reminded', [$oldest, $newest]);
        }

        $checkins = $query->get();
        $this->info('Sending '.$checkins->count().' reminder(s)');
        $checkins->each(function($checkin) {
            $this->info('Sending to '.$checkin->phone);
            SendReminderMessage::dispatch($checkin);
        });
    }
}
