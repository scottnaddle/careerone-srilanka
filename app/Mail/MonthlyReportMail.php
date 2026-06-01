<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reportContent;
    public $reportData;

    public function __construct($reportContent, $reportData)
    {
        $this->reportContent = $reportContent;
        $this->reportData = $reportData;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('CareerOne Platform - Monthly Report - ' . now()->format('F Y'))
            ->view('mail.monthly-report');
    }
}
