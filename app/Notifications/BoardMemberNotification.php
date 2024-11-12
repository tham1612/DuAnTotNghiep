<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class BoardMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $description; // Nội dung mô tả
    protected $title;       // Tiêu đề email
    protected $boardMember;

    public function __construct($title, $description, $boardMember)
    {
        $this->description = $description;
        $this->title = $title;
        $this->boardMember = $boardMember;
    }

    public function via($notifiable)
    {
        \Log::error("Notification via mail for user: " . $notifiable->id);
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //     ->subject($this->title)
        //     ->view('emails.workspace_member_notification', [
        //         'title' => $this->title,
        //         'description' => $this->description,
        //         'workspace_name' => $this->boardMember->board->name ?? 'Bảng chưa xác định',
        //         'recipient_name' => $this->boardMember->user->name ?? 'Bạn',
        //     ]);
        return (new MailMessage)->subject($this->title);
    }
}
