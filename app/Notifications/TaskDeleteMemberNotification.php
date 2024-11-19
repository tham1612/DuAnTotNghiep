<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeleteMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $admin;

    public function __construct($task, $admin)
    {
        $this->task = $task;
        $this->admin = $admin; // Gán adminName từ tham số
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.taskDeleteMember', [
                'task' => $this->task,
                'adminName' => $this->admin->name
            ])
            ->subject('Bạn đã bị xóa khỏi nhiệm vụ');
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'description' => 'Bạn bị xóa khỏi nhiệm vụ! - "<strong>' . $this->task->text . '</strong>"',
            'readed' => false,
            'name' => 'Bảng ' . $this->task->catalog->board->name,
            'title' => '🔔 Thông báo nhiệm vụ',
            'date' => now()->format('H:i d/m/Y')
        ];
    }
}

