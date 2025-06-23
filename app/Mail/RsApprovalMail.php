<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User; // Assuming you're passing a User model for $approver
use App\Models\RS\RSMaster; // Assuming you're passing an RSMaster model
use Illuminate\Support\Collection; // Assuming rsItems is a Collection

class RsApprovalMail extends Mailable // No longer implementing ShouldQueue
{
    use Queueable, SerializesModels;

    // Declare all properties as public for Mailable to access them in the view
    public $rsItems;
    public $rsMaster;
    public $approver;
    public $approvalToken;
    public $rejectToken;
    public $approvalNotReviewLink;
    public $approvalWithReviewLink;
    public $notApproveLink;


    /**
     * Create a new message instance.
     *
     * @param Collection $rsItems
     * @param User $approver
     * @param RSMaster $rsMaster
     * @param string $approvalToken
     * @param string $rejectToken
     * @param string $approvalNotReviewLink
     * @param string $approvalWithReviewLink
     * @param string $notApproveLink
     */
    public function __construct(
        Collection $rsItems,
        User $approver,
        RSMaster $rsMaster,
        string $approvalToken,
        string $rejectToken,
        string $approvalNotReviewLink,
        string $approvalWithReviewLink,
        string $notApproveLink
    ) {
        $this->rsItems = $rsItems;
        $this->rsMaster = $rsMaster;
        $this->approver = $approver;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;
        $this->approvalNotReviewLink = $approvalNotReviewLink;
        $this->approvalWithReviewLink = $approvalWithReviewLink;
        $this->notApproveLink = $notApproveLink;

        // Ensure these log entries are useful for debugging
        Log::info('RsApprovalMail created.', [
            'rsItems_count' => $this->rsItems->count(), // Log count instead of full array
            'approver_name' => $approver->name,
            'rs_master_id' => $rsMaster->id,
            'approvalNotReviewLink' => $approvalNotReviewLink,
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Approval Request for Requisition Slip: ' . $this->rsMaster->rs_no)
            ->view('mail.sendNotifAprroval')
            ->with([
                'rsItems' => $this->rsItems,
                'rsMaster' => $this->rsMaster,
                'approver' => $this->approver,
                // These are the simple approve/reject links from before (keep if still used)
                'approvalUrl' => route('rs.approve', ['token' => $this->approvalToken]),
                'rejectUrl' => route('rs.reject', ['token' => $this->rejectToken]),
                // Pass the specific action links to the view
                'approvalNotReviewLink' => $this->approvalNotReviewLink,
                'approvalWithReviewLink' => $this->approvalWithReviewLink,
                'notApproveLink' => $this->notApproveLink,
            ]);
    }
}