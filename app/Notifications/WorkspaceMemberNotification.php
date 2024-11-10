<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkspaceMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $description; // Nội dung mô tả
    protected $title;       // Tiêu đề email
    protected $wspMember;
    protected $action;

    public function __construct($title, $description, $wspMember, $action)
    {
        $this->description = $description;
        $this->title = $title;
        $this->wspMember = $wspMember;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        // Gửi thông qua mail và có thể mở rộng thêm database hoặc các kênh khác nếu cần
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->action == 0) {
            return (new MailMessage)
                ->subject($this->title)
                ->view('emails.workspace_member_notification', [
                    'title' => $this->title,
                    'description' => $this->description,
                    'workspace_name' => $wspMember->workspace->name ?? 'Không gian làm việc chưa xác định',
                    'recipient_name' => $wspMember0->user->name ?? 'Bạn',
                    // 'action_url' => url('/workspaces/' . ($workspace->id ?? '')),
                    'action_text' => 'Truy cập không gian làm việc',
                ]);
        }else{
            return (new MailMessage)
                ->subject($this->title)
                ->view('emails.workspace_member_notification', [
                    'title' => $this->title,
                    'description' => $this->description,
                    'workspace_name' => $wspMember->workspace->name ?? 'Không gian làm việc chưa xác định',
                    'recipient_name' => $wspMember0->user->name ?? 'Bạn',
                ]);
        }

    }
}
