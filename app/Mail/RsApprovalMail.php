<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RsApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rsMaster;
    public $approvalToken;
    public $rejectToken;

    public function __construct($rsMaster, $approvalToken, $rejectToken)
    {
        $this->rsMaster = $rsMaster;
        $this->approvalToken = $approvalToken;
        $this->rejectToken = $rejectToken;
    }

    public function build()
    {return $this->subject('Approval Request for Requisition Slip')
        ->view('emails.rs_approval')
        ->with([
            'rsMaster' => $this->rsMaster,
            'approvalUrl' => route('rs.approve', ['token' => $this->approvalToken]),
            'rejectUrl' => route('rs.reject', ['token' => $this->rejectToken]),
        ]);
    
    }
                       
}
