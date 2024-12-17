<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoardNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user; // Người được thêm vào không gian làm việc
    protected $board; // Không gian làm việc
    protected $name; // Không gian làm việc
    protected $description; // Không gian làm việc
    protected $title; // Không gian làm việc

    public function __construct($user, $board, $name, $description, $title)
    {
        $this->user = $user;
        $this->board = $board;
        $this->name = $name;
        $this->description = $description;
        $this->title = $title;
    }

    public function via($notifiable)
    {
        // Gửi thông qua mail và lưu vào database
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Lưu thông báo vào database
        return [
            'user_id' => $this->user->id,
            'workspace_id' => $this->board->workspace->id,
            'name' => $this->name,
            'description' => $this->description,
            'readed' => false,
            'title' => $this->title,
            'date' => now(),
        ];
    }
}
