<?php

namespace App\Mail;

use App\Models\RS\RSMaster;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RsApprovalNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rsMaster;
    public $approver;   // The User model of the approver who just took action
    public $approvalType; // e.g., 'approved_no_review', 'approved_with_review'

    /**
     * Create a new message instance.
     *
     * @param RSMaster $rsMaster The requisition slip master model instance.
     * @param User $approver The user who just approved the RS.
     * @param string $approvalType The type of approval (e.g., 'approved_no_review', 'approved_with_review').
     */
    public function __construct(RSMaster $rsMaster, User $approver, string $approvalType)
    {
        $this->rsMaster = $rsMaster;
        $this->approver = $approver;
        $this->approvalType = $approvalType;
    }

    /**
     * Get the message envelope.
     * This defines the email subject.
     */
    public function envelope(): Envelope
    {
        // Subject will be "Requisition Slip RSXXXX has been Approved (No Review)" etc.
        $subject = 'Requisition Slip ' . $this->rsMaster->rs_no . ' has been ' . str_replace('_', ' ', $this->approvalType);
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
            view: 'mail.sendToUser', // This Blade view needs to be created
            with: [
                'rsMaster' => $this->rsMaster,
                'approver' => $this->approver, // Who just approved it
                'approvalType' => $this->approvalType, // Type of approval (for display)
            ],
        );
    }

    // You can add attachments or customize headers here if needed.
    // public function attachments(): array
    // {
    //     return [];
    // }
}
