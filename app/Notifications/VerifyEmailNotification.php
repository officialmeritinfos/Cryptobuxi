<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;
    public $name;
    public $email;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $email, $token)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('complete-verification',[$this->email,sha1($this->token)]);
        return (new MailMessage)
                ->subject('Email Verification')
                ->greeting('Hello '.$this->name)
                ->line('Your account is almost created.')
                ->line('Click on the Link below to verify your email address and activate
                all the features of '.env('APP_NAME'))
                ->action('Verify Email', $url)
                ->line('Thank you for choosing '.env('APP_NAME'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
