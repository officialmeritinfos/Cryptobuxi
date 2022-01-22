<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    protected $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$title)
    {
        //initialize property
        $this->details=$details;
        $this->title=$title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('mails.notification_mail');
    }
}
