<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CgoCounseling;

class ProcessAutoAssignCounseling implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $counselingId;
    protected $historyId;

    public function __construct($data, $counselingId, $historyId)
    {
        $this->data = $data;
        $this->counselingId = $counselingId;
        $this->historyId = $historyId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $counseling = CgoCounseling::find($this->counselingId);

        if (!$counseling) {
            \Log::channel('queue')->error("Counseling not found for ID: {$this->counselingId}");
            return;
        }

        $traineeCounselingService = app()->make(\App\Services\Trainee\TraineeCounselingService::class);
        $result = $traineeCounselingService->autoAssignCounseling(
            $this->data,
            $counseling,
            $this->historyId,
        );

        \Log::channel('queue')->info("Auto-assign result: ", $result);
    }
}
