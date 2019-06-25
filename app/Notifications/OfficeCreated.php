<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfficeCreated extends Notification
{
    use Queueable;

    public $newOffice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($newOffice)
    {
        $this->newOffice = $newOffice;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('New Office')
        ->markdown('mail.office.created',[
        'newOffice' => $this->newOffice,
        ]);     
          // return (new MailMessage)->markdown('mail.office.created');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
