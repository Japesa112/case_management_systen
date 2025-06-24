<?php
namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\NewCaseCreated;
use App\Mail\NewCaseNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCaseNotifications implements ShouldQueue
{
    // Queue configuration
    public $queue = 'emails';
    public $tries = 3;

    public function handle(NewCaseCreated $event)
    {
        // Get recipients in batches for better memory handling
        User::whereIn('role', ['lawyer', 'admin'])
            ->chunk(200, function ($recipients) use ($event) {
                foreach ($recipients as $recipient) {
                    Mail::to($recipient->email)
                        ->queue(new NewCaseNotification($event->case));
                }
            });
    }

    // Handle failed jobs
    public function failed(NewCaseCreated $event, \Throwable $exception)
    {
        // Log error or notify admin
        Log::error("Failed to send case notifications: {$exception->getMessage()}");
    }
}