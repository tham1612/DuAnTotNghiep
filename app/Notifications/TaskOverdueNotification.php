<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskOverdueNotification extends Notification
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        // Gửi thông qua mail và lưu vào database
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        // Tạo email thông báox
        return (new MailMessage)
            ->subject('Task đã quá hạn')
            ->view('emails.taskOverDueDate', ['task' => $this->task]);
    }

    public function toDatabase($notifiable)
    {
        // Lưu thông báo vào database
        return [
            'task_id' => $this->task->id,
            'description' => "🔔 Task \"{$this->task->name}\" đã quá hạn, hãy nhanh chóng hoàn thành!",
            'readed' => false,
            'name' => $this->task->board->name ?? 'N/A',
            'title' => 'Thông báo quá hạn',
            'date' => now(),
        ];
    }
}
