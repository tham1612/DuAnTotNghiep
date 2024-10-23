<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkspaceMemberAddedNotification extends Notification
{
    use Queueable;
    protected $user; // Người được thêm vào không gian làm việc
    protected $workspace; // Không gian làm việc

    public function __construct($user, $workspace)
    {
        $this->user = $user;
        $this->workspace = $workspace;
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
            'description' => 'Người dùng "' . $this->user->name . '" đã được thêm vào không gian làm việc "' . $this->workspace->name . '".',
            'readed' => false,
            'title' => 'Thành viên mới trong không gian làm việc',
            'date' => now(),
        ];
    }
}
