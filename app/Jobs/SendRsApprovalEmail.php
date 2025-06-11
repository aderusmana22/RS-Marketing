<?php

namespace App\Jobs;

use App\Mail\RsApprovalMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendRsApprovalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rsItems;
    protected $approver;
    protected $rsMaster;
    protected $approvalToken;
    protected $rejectToken;

    public function __construct(User $approver, $rsMaster, $rsItems, $approvalToken, $rejectToken)
    {
        $this->rsItems = $rsItems;
        $this->approver = $approver;
        $this->rsMaster = $rsMaster;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;

        log::info('request slip items: ' . json_encode($this->rsItems));
        log::info('SendRsApprovalEmail job created for approver: ' . $approver->email);
        log::info('Requisition Slip Master ID: ' . json_encode($rsMaster));
        log::info('Approval Token: ' . $approvalToken);
        log::info('Reject Token: ' . $rejectToken);
    }

    public function handle()
    {
        $this->approver = $approver;
        $this->rsMaster = $rsMaster;
        $this->rsItems = $rsItems;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;

    $approvalNotReviewLink = route('view.mail.approved-no-review', [
            'rs_master_id' => $this->rsMaster->id,
            'approver_nik' => $this->approver->nik,
            'status' => 'approve',
            'token' => $this->approvalToken
        ]);
    $approvalWithReviewLink = route('view.mail.approved-with-review', [
            'rs_master_id' => $this->rsMaster->id,
            'approver_nik' => $this->approver->nik,
            'status' => 'approve with review',
            'token' => $this->approvalToken
        ]);
    $notApproveLink = route('view.mail.not-approved', [
            'rs_master_id' => $this->rsMaster->id,
            'approver_nik' => $this->approver->nik,
            'status' => 'not approve',
            'token' => $this->approvalToken
        ]);

        Mail::to($this->approver->email)->send(new RsApprovalMail($this->rsItems, $this->approver, $this->rsMaster, $this->approvalToken, $this->rejectToken, 
            $approvalNotReviewLink, $approvalWithReviewLink, $notApproveLink));
    }
}
