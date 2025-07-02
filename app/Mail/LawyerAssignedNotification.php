<?php

namespace App\Mail;

use App\Models\CaseModel;
use App\Models\User;
use App\Models\DvcAppointmentAttachment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LawyerAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $case;
    public $lawyer;
    public $attachment; // just one

    public function __construct(CaseModel $case, User $lawyer, ?DvcAppointmentAttachment $attachment = null)
    {
        $this->case = $case;
        $this->lawyer = $lawyer;
        $this->attachment = $attachment;
    }

    public function build()
    {
        $email = $this->subject('You Have Been Assigned to a New Case')
                      ->markdown('emails.lawyer-assigned', [
                          'attachment' => $this->attachment
                      ]);

        // Attach single file
        if ($this->attachment) {
            $filePath = storage_path('app/public/dvc_attachments/' . $this->attachment->file_name);
            if (file_exists($filePath)) {
                $email->attach($filePath, [
                    'as' => $this->attachment->file_path,
                    'mime' => $this->attachment->file_type,
                ]);
            }
        }

        return $email;
    }
}
