<?php

namespace App\Mail;
use App\Models\CaseModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class LawyerAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $case;
    public $lawyer;

    public function __construct(CaseModel $case, User $lawyer)
    {
        $this->case = $case;
        $this->lawyer = $lawyer;
    }

    public function build()
    {
        return $this->subject('You Have Been Assigned to a New Case')
                    ->markdown('emails.lawyer-assigned');
    }
}