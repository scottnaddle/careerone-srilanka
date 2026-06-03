<?php

namespace App\Jobs;

use App\Models\CgoCounseling;
use App\Models\CgoUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignCounselingSession implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Counseling instance.
     *
     * @var object|CgoCounseling $counseling
     */
    private object $counseling;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public int $uniqueFor = 3600;

    /**
     * Create a new job instance.
     */
    public function __construct(CgoCounseling $counseling)
    {
        $this->counseling = $counseling->withoutRelations();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get cgo user free to assign
        $cgoUser = CgoUser::query()
            ->where('institute_id', $this->counseling->institute_id)
            ->

        DB::transaction(function () {
            $this->autoAssignCounseling();
        });
        //TODO: Implement the logic to auto-assign the counseling.
        \DB::table('cgo_counseling_assign_histories')->update([
            'assignee_to' => null,
        ]);
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return $this->counseling->id;
    }
}
