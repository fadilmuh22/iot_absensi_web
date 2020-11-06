<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $qrCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $qrCode)
    {
        $this->user = $user;
        $this->qrCode = $qrCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.event_mail');
    }
}
