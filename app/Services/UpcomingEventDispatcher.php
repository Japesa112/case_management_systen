<?php

namespace App\Services;

use App\User;
use App\Models\CaseLawyer;
use App\Mail\UpcomingReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class UpcomingEventDispatcher
{
    protected $upcomingEvents;

    public function __construct(array $upcomingEvents)
    {
        $this->upcomingEvents = collect($upcomingEvents);
    }

    public function dispatch()
    {
        $this->sendToAdmins();
        $this->sendToLawyers();
    }

        protected function sendToAdmins()
    {
        $now = now();
        $admins = User::where('role', 'Admin')->whereNotNull('email')->get();

        foreach ($admins as $admin) {

             $pref = $admin->notificationPreference;

                if (!$pref) continue;

                    // Match time
                $timeMatch = $now->format('H:i') === Carbon::parse($pref->time)->format('H:i');
                Log::info("Time Now: " . $now->format('H:i') . " | Preference Time: " . Carbon::parse($pref->time)->format('H:i'));
                $dayMatch = $pref->frequency === 'daily' ||
                                ($pref->frequency === 'weekly' && intval($pref->day_of_week) === $now->dayOfWeek);

                Log::info("Time Match is: ".$timeMatch." Day Match: ".$dayMatch);

                if (!($timeMatch && $dayMatch)) continue;


            Mail::to($admin->email)->queue(new UpcomingReminder($this->upcomingEvents->toArray()));

            Log::info("Queued upcoming digest for Admin {$admin->email}", [
                'items_count' => $this->upcomingEvents->count(),
            ]);
        }
    }


   protected function sendToLawyers()
    {

        $now = now();
        $lawyerAssignments = CaseLawyer::all()->groupBy('lawyer_id');

        foreach ($lawyerAssignments as $lawyerId => $cases) {
            $lawyer = \App\Models\Lawyer::with('user')->find($lawyerId);

            if (!$lawyer || !$lawyer->user || !$lawyer->user->email) {
                continue;
            }

            $user = $lawyer->user;

            $caseIds = $cases->pluck('case_id')->toArray();

            $filteredEvents = $this->upcomingEvents->filter(function ($event) use ($caseIds) {
                return in_array($event['case_id'], $caseIds);
            });

            if ($filteredEvents->isNotEmpty()) {

                $pref = $user->notificationPreference;

                if (!$pref) continue;

                    // Match time
                $timeMatch = $now->format('H:i') === Carbon::parse($pref->time)->format('H:i');
                Log::info("Time Now: " . $now->format('H:i') . " | Preference Time: " . Carbon::parse($pref->time)->format('H:i'));
                $dayMatch = $pref->frequency === 'daily' ||
                                ($pref->frequency === 'weekly' && intval($pref->day_of_week) === $now->dayOfWeek);

                Log::info("Time Match is: ".$timeMatch." Day Match: ".$dayMatch);

                if (!($timeMatch && $dayMatch)) continue;

                Mail::to($user->email)->queue(new UpcomingReminder($filteredEvents->toArray()));

                Log::info("Queued upcoming digest for Lawyer {$user->email}", [
                    'items_count' => $filteredEvents->count(),
                ]);
            }
        }
    }

}
