<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoardMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $desciption;
    protected $title;

    public function __construct($title, $desciption)
    {

        $this->desciption = $desciption;
        $this->title = $title;
    }
    public function via($notifiable)
    {
        // Gửi thông qua mail và lưu vào database
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Tạo email thông báox
        return (new MailMessage)
            ->subject($this->title)
            ->line($this->desciption);
    }
}

