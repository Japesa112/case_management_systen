<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Log;

use Illuminate\Queue\SerializesModels;
use App\Models\CaseModel; // ✅ Correct namespace


class GeneralLawyerMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $case;
    public $customMessage;

    public function __construct(CaseModel $case, $customMessage)
    {
        $this->case = $case;
        $this->customMessage = $customMessage;
    }

    public function build()
    {
        try {
            // Log that the build is being attempted
            Log::info('Building GeneralLawyerMessage email for case: ' . ($this->case->case_name ?? 'N/A'));

            return $this->subject('Message Regarding Case: ' . ($this->case->case_name ?? 'Unknown Case'))
                        ->markdown('emails.lawyer-message');
        } catch (\Exception $e) {
            // Log the error to laravel.log
            Log::error('Failed to build GeneralLawyerMessage email: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            // Optionally rethrow or return a basic fallback
            throw $e; // or return a fallback response/mailable if you want to recover
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'General Lawyer Message',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lawyer-message',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
