<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteBoardMail extends Mailable
{
    use Queueable, SerializesModels;


    public $boardName;
    public $linkInvite;
    public $email;
    public $authorize;

    public function __construct($boardName, $linkInvite, $email, $authorize)
    {
        $this->boardName = $boardName;
        $this->linkInvite = $linkInvite;
        $this->email = $email;
        $this->authorize = $authorize;
    }

    public function build()
    {
        return $this
            ->subject('You are invited to join a workspace')
            ->view('emails.inviteBoard'); // Đảm bảo đường dẫn view là đúng
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invite Workspace Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inviteBoard', // Thay đổi từ 'view.name' thành 'emails.invite'
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
