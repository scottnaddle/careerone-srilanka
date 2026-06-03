<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonMailable;

use App\Services\EmailService;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $emailContent;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $emailContent
     */
    public function __construct($user, $emailContent)
    {
        $this->user = $user;
        $this->emailContent = $emailContent;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->user->email)
        ->send(new CommonMailable( $this->emailContent['subject'], $this->emailContent['view'],$this->emailContent['data']));
    }
}