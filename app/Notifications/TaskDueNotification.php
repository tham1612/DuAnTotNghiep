<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TaskDueNotification extends Notification implements ShouldQueue
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
            ->view('emails.taskReminder', ['task' => $this->task])
            ->subject('Task sắp đến hạn');
    }

    public function toDatabase($notifiable)
    {
        // Lưu thông báo vào database
        return [
            'task_id' => $this->task->id,
            'description' => '🔔 Task "' . $this->task->text . '" này sắp đến hạn, hãy nhanh chóng hoàn thành!',
            'readed' => false,
            'name' => $this->task->catalog->board->name,
            'title' => 'Thông báo đến hạn',
            'date' => now()
        ];
    }
}
