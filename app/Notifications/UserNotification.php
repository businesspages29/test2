<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    //ShouldQueue
    //implements ShouldQueue
    use Queueable;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Notification Subject')
                //->greeting('Hello!')
                ->greeting($this->details['greeting'])
                //->line('The introduction to the notification.')
                ->line($this->details['body'])
                //->action('Notification Action', url('/'))
                ->action($this->details['actionText'], $this->details['actionURL'])
                //->line('Thank you for using our application!');
                ->line($this->details['thanks']);
    }

    public function toArray($notifiable)
    {
        return [
           'data' => 'this is my notification',
        ];
    }
}
