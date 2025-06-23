<?php

namespace App\Jobs;

use App\Mail\RsApprovalMail;
use App\Models\RS\RSMaster; // Ensure correct namespace
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;


class SendRsApprovalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rsItems;
    public $approver;
    public $rsMaster;
    public $approvalToken;
    public $rejectToken;
    public $approvalNotReviewLink; // New property
    public $approvalWithReviewLink; // New property
    public $notApproveLink;       // New property

    /**
     * Create a new job instance.
     *
     * @param User $approver The User model instance of the approver.
     * @param RSMaster $rsMaster The RSMaster model instance.
     * @param Collection $rsItems The collection of requisition slip items.
     * @param string $approvalToken Encrypted approval token.
     * @param string $rejectToken Encrypted rejection token.
     * @param string $approvalNotReviewLink Pre-generated URL for "Approved No Review".
     * @param string $approvalWithReviewLink Pre-generated URL for "Approved With Review".
     * @param string $notApproveLink Pre-generated URL for "Not Approved".
     */
    public function __construct(
        User $approver,
        RSMaster $rsMaster,
        Collection $rsItems,
        string $approvalToken,
        string $rejectToken,
        string $approvalNotReviewLink, // Add new parameter
        string $approvalWithReviewLink, // Add new parameter
        string $notApproveLink          // Add new parameter
    ) {
        $this->rsItems = $rsItems;
        $this->approver = $approver;
        $this->rsMaster = $rsMaster;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;
        $this->approvalNotReviewLink = $approvalNotReviewLink; // Assign
        $this->approvalWithReviewLink = $approvalWithReviewLink; // Assign
        $this->notApproveLink = $notApproveLink;             // Assign

        Log::info('Request slip items (from job constructor): ' . json_encode($this->rsItems));
        Log::info('SendRsApprovalEmail job created for approver: ' . $approver->email);
        Log::info('Requisition Slip Master ID (from job constructor): ' . json_encode($rsMaster));
        Log::info('Approval Token (from job constructor): ' . $this->approvalToken);
        Log::info('Reject Token (from job constructor): ' . $this->rejectToken);
        Log::info('Generated Link: approvalNotReviewLink: ' . $this->approvalNotReviewLink); // Log new links
        Log::info('Generated Link: approvalWithReviewLink: ' . $this->approvalWithReviewLink);
        Log::info('Generated Link: notApproveLink: ' . $this->notApproveLink);
    }

    public function handle(): void
    {
        if (!$this->approver || !($this->approver instanceof User)) {
            Log::error('Job: Approver not correctly set in handle method.');
            return;
        }
        if (!$this->rsMaster) {
            Log::error('Job: RSMaster not correctly set in handle method.');
            return;
        }

        // NO LINK GENERATION HERE - links are already generated and available as $this->properties

        Mail::to($this->approver->email)->send(new RsApprovalMail(
            $this->rsItems,
            $this->approver,
            $this->rsMaster,
            $this->approvalToken,
            $this->rejectToken,
            $this->approvalNotReviewLink, // Pass pre-generated links from job properties
            $this->approvalWithReviewLink,
            $this->notApproveLink
        ));

        Log::info('Email for RS Approval dispatched successfully to: ' . $this->approver->email);
    }
}