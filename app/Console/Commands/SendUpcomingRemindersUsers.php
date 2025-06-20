<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SendUpcomingNotificationJob;
use Carbon\Carbon;

class SendUpcomingRemindersUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upcoming:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Send upcoming event reminders based on user notification preferences';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $users = User::with('notificationPreference')->get();

        foreach ($users as $user) {
            $pref = $user->notificationPreference;

            if (!$pref) continue;

            $timeMatch = $now->format('H:i') === $pref->time;
            $dayMatch = $pref->frequency === 'daily' ||
                        ($pref->frequency === 'weekly' && $now->dayOfWeek === intval($pref->day_of_week));

            if ($timeMatch && $dayMatch) {
                dispatch(new SendUpcomingNotificationJob($user));
                $this->info("Queued reminder for {$user->email}");
            }
        }

        return 0;
    }
}
