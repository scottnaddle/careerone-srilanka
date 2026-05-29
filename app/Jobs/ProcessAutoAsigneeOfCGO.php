<?php

namespace App\Jobs;

use App\Models\CgoCounseling;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAutoAsigneeOfCGO implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $counselingId;
    /**
     * Create a new job instance.
     */
    public function __construct($counselingId)
    {
        $this->counselingId=$counselingId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $counseling = CgoCounseling::find($this->counselingId);

        if (!$counseling) {
            \Log::channel('queue')->error("Counseling not found for ID: {$this->counselingId}");
            return;
        }

        $counselingService = app()->make(\App\Services\Cgo\CounselingService::class);
        $result = $counselingService->autoAssignCounseling(
            $counseling,
        );

        \Log::channel('queue')->info("Auto-assign result: ", $result);
    }
}
