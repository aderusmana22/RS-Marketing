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

    protected $approver;
    protected $rsMaster;
    protected $approvalToken;
    protected $rejectToken;

    public function __construct(User $approver, $rsMaster, $approvalToken, $rejectToken)
    {
        $this->approver = $approver;
        $this->rsMaster = $rsMaster;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;

        log::info('SendRsApprovalEmail job created for approver: ' . $approver->email);
        log::info('Requisition Slip Master ID: ' . json_encode($rsMaster));
        log::info('Approval Token: ' . $approvalToken);
        log::info('Reject Token: ' . $rejectToken);
    }

    public function handle()
    {
        Mail::to($this->approver->email)->send(new RsApprovalMail($this->approver, $this->rsMaster, $this->approvalToken, $this->rejectToken));
    }
}
