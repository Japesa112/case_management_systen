<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\{
    Negotiation,
    LawyerPayment,
    Payment,
    AGAdvice,
    Forwarding,
    Trial,
    TrialPreparation,
    PreTrial,
    Adjourn,
    Appeal,
    CaseActivity
};

class UpcomingEventService
{
    public function getUpcomingEvents(): array
    {
        $upcoming = collect();

        $upcoming = $upcoming->merge(
            Negotiation::with('caseRecord')->get()
                ->filter(fn($n) => Carbon::parse($n->initiation_datetime)->isFuture())
                ->map(fn($n) => [
                'type' => 'Negotiation',
                'description' => $n->subject ?? 'No description',
                'case_id' => $n->case_id,
                'case_name' => optional($n->caseRecord)->case_name ?? 'Unknown Case',
                'datetime' => Carbon::parse($n->initiation_datetime)->toDateTimeString(),
                'badge_color' => 'rgb(6, 53, 80)'
            ])
        );

                $upcoming = $upcoming->merge(
            LawyerPayment::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Lawyer Payment',
                    'description' => $p->transaction ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->toDateTimeString(),
                    'badge_color' => 'rgb(14, 168, 22)'
                ])
               );

        $upcoming = $upcoming->merge(
            Payment::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Payment',
                    'description' => $p->transaction ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->toDateTimeString(),
                    'badge_color' => 'rgb(194, 15, 218)'
                ])
        );

        $upcoming = $upcoming->merge(
            AGAdvice::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->advice_date . ' ' . $p->advice_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'AG Advice',
                    'description' => $p->ag_advice ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->advice_date . ' ' . $p->advice_time)->toDateTimeString(),
                    'badge_color' => '#272838'
                ])
        );

        $upcoming = $upcoming->merge(
            Forwarding::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->dvc_appointment_date . ' ' . $p->dvc_appointment_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'DVC Forwarding',
                    'description' => $p->briefing_notes ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->dvc_appointment_date . ' ' . $p->dvc_appointment_time)->toDateTimeString(),
                    'badge_color' => '#F2B418'
                ])
        );

        $upcoming = $upcoming->merge(
            Trial::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->trial_date . ' ' . $p->trial_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Trial',
                    'description' => $p->judgement_details ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->trial_date . ' ' . $p->trial_time)->toDateTimeString(),
                    'badge_color' => '#F2B418'
                ])
        );

         $upcoming = $upcoming->merge(
            TrialPreparation::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->preparation_date . ' ' . $p->preparation_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Preparation',
                    'description' => $p->briefing_notes ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->preparation_date . ' ' . $p->preparation_time)->toDateTimeString(),
                    'badge_color' => '#445D48'
                ])
        );

         $upcoming = $upcoming->merge(
            PreTrial::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->pretrial_date . ' ' . $p->pretrial_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'PreTrial',
                    'description' => $p->comments ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->pretrial_date . ' ' . $p->pretrial_time)->toDateTimeString(),
                    'badge_color' => '#454d46'
                ])
        );

        $upcoming = $upcoming->merge(
            Adjourn::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Adjourn',
                    'description' => $p->adjourn_comments ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->toDateTimeString(),
                    'badge_color' => '#F57251'
                ])
        );

        $upcoming = $upcoming->merge(
            Appeal::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Appeal',
                    'description' => $p->appeal_comments ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->toDateTimeString(),
                    'badge_color' => '#C4AD9D'
                ])
        );

        $upcoming = $upcoming->merge(
            CaseActivity::with('case')->get()
                ->filter(fn($p) => Carbon::parse($p->date->format('Y-m-d'). ' ' . $p->time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Court Session',
                    'description' => $p->type ?? 'No description',
                    'case_id' => $p->case_id,
                    'case_name' => optional($p->case)->case_name ?? 'Unknown Case',
                    'datetime' => Carbon::parse($p->date->format('Y-m-d') . ' ' . $p->time)->toDateTimeString(),
                    'badge_color' => '#C4AD9D'
                ])
        );


        // You can now add all your other model filters here...

        return $upcoming->sortBy('datetime')->take(10)->values()->toArray();
    }
}
