<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;
use App\Enums\JobStatusEnum;
use App\Models\OJT;

class ChangeStatusJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-status-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the job status based on application_starttime and application_endtime to decide what status it will be';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = date('Y-m-d');
        $records = Job::all();
        foreach ($records as $record) {
            $status = JobStatusEnum::PROGRESS->value;
            $startTime = !empty($record->application_starttime) ? date('Y-m-d', strtotime($record->application_starttime)) : null;
            $endTime = !empty($record->application_endtime) ? date('Y-m-d', strtotime($record->application_endtime)) : null;
    
            if ($startTime && $endTime) {
                if ($currentDate < $startTime || $currentDate > $endTime) {
                    $status = JobStatusEnum::CANCEL->value;
                }
            } elseif ($startTime && !$endTime) {
                if ($currentDate < $startTime) {
                    $status = JobStatusEnum::CANCEL->value;
                }
            } elseif (!$startTime && $endTime) {
                if ($currentDate > $endTime) {
                    $status = JobStatusEnum::CANCEL->value;
                }
            }
            $record->update(['status' => $status]);
        }
        $ojt = OJT::all();
        foreach ($ojt as $record) {
            $status = JobStatusEnum::PROGRESS->value;
            $startTime = !empty($record->application_starttime) ? date('Y-m-d', strtotime($record->application_starttime)) : null;
            $endTime = !empty($record->application_endtime) ? date('Y-m-d', strtotime($record->application_endtime)) : null;
    
            if ($startTime && $endTime) {
                if ($currentDate < $startTime || $currentDate > $endTime) {
                    $status = JobStatusEnum::CANCEL->value;
                }
            } elseif ($startTime && !$endTime) {
                if ($currentDate < $startTime) {
                    $status = JobStatusEnum::CANCEL->value;
                }
            } elseif (!$startTime && $endTime) {
                if ($currentDate > $endTime) {
                    $status = JobStatusEnum::CANCEL->value;
                }
            }
            $record->update(['status' => $status]);
        }
    }
    
}
