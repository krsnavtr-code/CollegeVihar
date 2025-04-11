<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $email = $this->subject($this->details['subject']);

        // Use proposal template if it's a proposal email
        if (isset($this->details['is_proposal']) && $this->details['is_proposal']) {
            $email->view('emails.proposal_email')
                 ->with([
                    'subject' => $this->details['subject'],
                    'cover_letter' => $this->details['cover_letter'] ?? ''
                ]);
        } else {
            $email->view('emails.custom_email')
                 ->with('details', $this->details);
        }

        // Attach proposal PDF if it exists
        if (isset($this->details['proposal_pdf'])) {
            $email->attach($this->details['proposal_pdf']);
        }

        // Attach additional attachments
        if (!empty($this->details['additional_attachments'])) {
            foreach ($this->details['additional_attachments'] as $file) {
                $email->attach($file);
            }
        }

        return $email;
    }
}
