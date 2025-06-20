<?php

namespace App\Jobs;

use App\Mail\RsApprovalNotificationMail;
use App\Models\RS\RSMaster;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRsApprovalUpdateNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public RSMaster $rsMaster;
    public User $approver;      // The approver who just took action
    public string $approvalType; // e.g., 'approved_no_review', 'approved_with_review'
    public User $initiator;     // The initiator to whom the email should be sent

    /**
     * Create a new job instance.
     *
     * @param RSMaster $rsMaster The requisition slip master.
     * @param User $initiator The initiator to send the email to.
     * @param User $approver The user who just approved the RS.
     * @param string $approvalType The type of approval (e.g., 'approved_no_review').
     */
    public function __construct(RSMaster $rsMaster, User $initiator, User $approver, string $approvalType)
    {
        $this->rsMaster = $rsMaster;
        $this->initiator = $initiator;
        $this->approver = $approver;
        $this->approvalType = $approvalType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Basic check to ensure the initiator has an email.
        if (empty($this->initiator->email)) {
            Log::warning('Intermediate approval notification skipped: Initiator ' . $this->initiator->nik . ' has no email address for RS: ' . $this->rsMaster->rs_no);
            return;
        }

        try {
            Mail::to($this->initiator->email)->send(
                new RsApprovalNotificationMail(
                    $this->rsMaster,
                    $this->approver,
                    $this->approvalType
                )
            );
            Log::info('Intermediate approval notification email dispatched successfully to initiator ' . $this->initiator->email . ' for RS: ' . $this->rsMaster->rs_no);
        } catch (\Exception $e) {
            Log::error('Failed to send intermediate approval notification email for RS: ' . $this->rsMaster->rs_no . ' to initiator ' . $this->initiator->email, [
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);
            // Consider re-throwing the exception if you want Laravel to retry the job based on your queue configuration.
            // throw $e;
        }
    }
}
