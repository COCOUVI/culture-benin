<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageTest;

    public function __construct($messageTest)
    {
        $this->messageTest = $messageTest;
    }

    public function build()
    {
        return $this->subject('Test Email Hostinger')
            ->view('emails.test');
    }
}
