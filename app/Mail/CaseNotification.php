<?php  



namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CaseModel; // use the correct model namespace
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CaseNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $case;
    public $isReminder;
    public $customMessage; // 👈 Add this

    public function __construct($case, $isReminder = false, $customMessage = null)
    {
        $this->case = $case;
        $this->isReminder = $isReminder;
        $this->customMessage = $customMessage; // 👈 Assign it
    }

    public function build()
    {
        Log::info('Building CaseNotification email', ['case_id' => $this->case->case_id ?? null]);

        return $this->subject($this->isReminder ? 'Hearing Date Reminder' : 'New Case Created')
                    ->markdown('emails.case-notification');
    }
}


