<?php
namespace App\Mail;

use App\Models\CaseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCaseNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $case;
    public $isReminder;

    // Queue configuration
    public $tries = 3;
    public $backoff = 60;

    public function __construct(CaseModel $case, $isReminder = false)
    {
        $this->case = $case;
        $this->isReminder = $isReminder;
    }

    public function build()
    {
        $subject = $this->isReminder 
            ? "Hearing Reminder: {$this->case->title}"
            : "New Case Created: {$this->case->title}";

        return $this->subject($subject)
                    ->markdown('emails.case-notification');
    }
}