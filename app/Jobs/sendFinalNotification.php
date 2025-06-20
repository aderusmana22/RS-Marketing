<?php

namespace App\Jobs;

use App\Mail\RsFinalNotificationMail;
// Remove unused imports like FinalNotification and Requisitionform if they are not used.
// use App\Mail\FinalNotification; // Likely unused
// use App\Models\Requisitionform; // Likely unused
use App\Models\RS\RSMaster; // Ensure this is the correct namespace
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendFinalNotification implements ShouldQueue // Changed class name to match file name case
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $recipientUser;
    public RSMaster $rsMaster;
    public string $finalStatus;
    public ?string $comment;
    public User $actionByUser;

    public function __construct(
        User $recipientUser,
        RSMaster $rsMaster,
        string $finalStatus,
        ?string $comment,
        User $actionByUser
    ) {
        $this->recipientUser = $recipientUser;
        $this->rsMaster = $rsMaster;
        $this->finalStatus = $finalStatus;
        $this->comment = $comment;
        $this->actionByUser = $actionByUser;
    }

    public function handle(): void
    {
        Log::info('Attempting to send final notification email.', [
            'rs_no' => $this->rsMaster->rs_no,
            'recipient_email' => $this->recipientUser->email,
            'final_status' => $this->finalStatus,
        ]);

        try {
            Mail::to($this->recipientUser->email)->send(
                new RsFinalNotificationMail(
                    $this->rsMaster,
                    $this->finalStatus,
                    $this->comment,
                    $this->actionByUser
                )
            );
            Log::info('Final notification email dispatched successfully for RS: ' . $this->rsMaster->rs_no . ' to ' . $this->recipientUser->email);
        } catch (\Exception $e) {
            Log::error('Failed to send final notification email for RS: ' . $this->rsMaster->rs_no . ' to ' . $this->recipientUser->email, [
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);
            // Consider re-throwing the exception if your queue setup handles retries.
            // throw $e;
        }
    }
}