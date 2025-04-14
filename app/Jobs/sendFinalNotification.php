<?php

namespace App\Jobs;

use App\Mail\FinalNotification;
use App\Models\Requisitionform;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class sendFinalNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $form;
    

    public function __construct(user $user, form $form)
    {
        $this->user = $user;
        $this->pcr = $form;
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new FinalNotification($this->form));
    }
}
