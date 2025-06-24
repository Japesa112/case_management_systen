<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\UpcomingReminder;
use Carbon\Carbon;
use App\Http\Controllers\MainController; // or extract logic to a service
use App\Services\UpcomingEventService;
use App\Services\UpcomingEventDispatcher;

class SendUpcomingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:upcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for upcoming hearings, payments, and events';

    /**
     * Execute the console command.
     */
       public function handle()
        {
            try {
                $service = new UpcomingEventService();
                $items = $service->getUpcomingEvents();

                if (empty($items)) {
                    Log::info('No upcoming items to notify.');
                    return;
                }

                $dispatcher = new UpcomingEventDispatcher($items);
                $dispatcher->dispatch();

                $this->info("Digest notifications queued.");
            } catch (\Throwable $e) {
                Log::error('Failed to send upcoming digest: ' . $e->getMessage());
                $this->error('Something went wrong.');
            }
        }



}
