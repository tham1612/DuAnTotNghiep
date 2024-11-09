<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddMemberChecklistNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $checkListItemMember;
    protected $admin;

    public function __construct($checkListItemMember, $admin)
    {
        $this->checkListItemMember = $checkListItemMember;
        $this->admin = $admin; // Gán admin từ tham số
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.checklistAssigned', [
                'checkListItemMember' => $this->checkListItemMember,
                'adminName' => $this->admin->name
            ])
            ->subject('Bạn được thêm vào checklist');
    }

    public function toDatabase($notifiable)
    {
        return [
            'checklist_id' => $this->checkListItemMember->checkListItem->id,
            'description' => 'Bạn đã được thêm vào checklist - "<strong>' . $this->checkListItemMember->checkListItem->checkList->name . '</strong>"',
            'readed' => false,
            'name' => 'Bảng ' . $this->checkListItemMember->checkListItem->checkList->task->catalog->board->name,
            'title' => '🔔 Thông báo checklist',
            'date' => now()->format('H:i d/m/Y')
        ];
    }
}
