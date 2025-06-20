<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RS\RSMaster; // Ensure this is the correct namespace for your RSMaster model
use App\Models\User;     // Ensure this is the correct namespace for your User model

class RsFinalNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rsMaster;
    public $finalStatus; // Will be 'approved' or 'rejected'
    public $comment;
    public $actionBy;    // The User model of who performed the final action (approver/rejecter)

    /**
     * Create a new message instance.
     *
     * @param RSMaster $rsMaster The requisition slip master model instance.
     * @param string $finalStatus The final status ('approved' or 'rejected').
     * @param string|null $comment Any comment associated with the final action.
     * @param User $actionBy The user model of who performed the action.
     */
    public function __construct(RSMaster $rsMaster, string $finalStatus, ?string $comment, User $actionBy)
    {
        $this->rsMaster = $rsMaster;
        $this->finalStatus = $finalStatus;
        $this->comment = $comment;
        $this->actionBy = $actionBy;
    }

    /**
     * Get the message envelope.
     * This defines the email subject.
     */
    public function envelope(): Envelope
    {
        // Subject will be "Requisition Slip RSXXXX - Approved" or "Requisition Slip RSXXXX - Rejected"
        $subject = 'Requisition Slip ' . $this->rsMaster->rs_no . ' - ' . ucfirst($this->finalStatus);
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     * This specifies the Blade view for the email content.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.rsFinalNotification', // This Blade view needs to be created
            with: [
                'rsMaster' => $this->rsMaster,
                'finalStatus' => $this->finalStatus,
                'comment' => $this->comment,
                'actionBy' => $this->actionBy,
            ],
        );
    }

    // You can add attachments or customize headers here if needed.
    // public function attachments(): array
    // {
    //     return [];
    // }
}