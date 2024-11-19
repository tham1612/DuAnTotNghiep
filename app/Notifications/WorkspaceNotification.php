<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkspaceNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user; // Người được thêm vào không gian làm việc
    protected $workspace; // Không gian làm việc
    protected $name; // Không gian làm việc
    protected $description; // Không gian làm việc
    protected $title; // Không gian làm việc

    public function __construct($user, $workspace, $name, $description, $title)
    {
        $this->user = $user;
        $this->workspace = $workspace;
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
            'workspace_id' => $this->workspace->id,
            'name' => $this->name,
            'description' => $this->description,
            'readed' => false,
            'title' => $this->title,
            'date' => now(),
        ];
    }
}

