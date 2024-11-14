<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoardMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $description; // Nội dung mô tả
    protected $title;       // Tiêu đề email
    protected $boardName;
    protected $boardMemberName;

    public function __construct($title, $description, $boardName, $boardMemberName)
    {
        $this->title = $title;
        $this->description = $description;
        $this->boardName = $boardName;
        $this->boardMemberName = $boardMemberName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->view('emails.workspace_member_notification', [
                'title' => $this->title,
                'description' => $this->description,
                'workspace_name' => $this->boardName ?? 'Bảng chưa xác định',
                'recipient_name' => $this->boardMemberName ?? 'Bạn',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
