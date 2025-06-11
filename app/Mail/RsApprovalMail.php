<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RsApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rsItems;
    public $rsMaster;
    public $approver;
    public $approvalToken;
    public $rejectToken;

    public function __construct($rsItems, $approver, $rsMaster, $approvalToken, $rejectToken)
    {
        $this->rsItems = $rsItems;
        $this->rsMaster = $rsMaster;
        $this->approver = $approver;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;
        log::info('RsApprovalMail created with items: ' . json_encode($this->rsItems));
        log::info('RsApprovalMail created for approver mail: ' . $approver->name);
        log::info('Requisition Slip Master ID mail: ' . json_encode($rsMaster));
        log::info('Approval Token mail: ' . $approvalToken);
        log::info('Reject Token mail: ' . $rejectToken);
    }

    public function build()
    {return $this->subject('Approval Request for Requisition Slip')
        ->view('mail.sendNotifAprroval')
        ->with([
            'rsItems' => $this->rsItems,
            'rsMaster' => $this->rsMaster, 
            'approver' => $this->approver,
            'approvalUrl' => route('rs.approve', ['token' => $this->approvalToken]),
            'rejectUrl' => route('rs.reject', ['token' => $this->rejectToken]),
        ]);
    
    }
                       
}
