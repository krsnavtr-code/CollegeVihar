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
        $email = $this->subject($this->details['subject'])
                      ->view('emails.custom_email')
                      ->with('details', $this->details);

        // Attachments ko yaha add karo
        if (!empty($this->details['attachments'])) {
            foreach ($this->details['attachments'] as $file) {
                $email->attach($file);
            }
        }

        return $email;
    }
}
