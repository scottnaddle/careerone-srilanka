<?php

namespace App\Services\Trainee;

use App\Enums\JobStatusEnum;
use App\Enums\TypeTraineeApply;
use App\Models\Job;
use App\Models\TraineeApply;
use App\Services\Company\NotificationManager;
use App\Models\TraineeUser;
class TraineeAppliesService
{
    protected object $model;
    protected $notificationManager;
    /**
     * TraineeAppliesService constructor.
     * @param TraineeApply $model
     */
    public function __construct(TraineeApply $model, NotificationManager $notificationManager) {
        $this->model = $model;
        $this->notificationManager = $notificationManager;
    }

    /**
     *
     * @param $request
     * @return string|bool
     */
    public function toggleApply($request)
    {
        try {
            $job = Job::with('companyRecruiter')->find($request['job_id']);
            if($job->status == JobStatusEnum::CANCEL->value) {
                return 'cancel';
            }

            if ($request->bearerToken()) {
                $trainee = auth('sanctum')->user();
            } else {
                $trainee = auth()->guard('trainee')->user();
            }
            $trainee_id = $trainee->id;

            $traineeApply = $this->model::where('trainee_id', $trainee_id)->where('job_id', $request['job_id'])->where('apply_type', TypeTraineeApply::APPLY->value)->first();

            if ($traineeApply) {
                $traineeApply->delete();
                return 'unapply';
            }
            else{

                $trainee_fullname= $trainee->full_name ?? $trainee->first_name.' '.$trainee->last_name ;
            }
            $this->model::create([
                'job_id' => $request['job_id'],
                'trainee_id' => $trainee_id,
                'apply_time' => now(),
                'apply_type' => TypeTraineeApply::APPLY,
            ]);
            $this->notificationManager->sendToggleApplyNotification($trainee_fullname,$job);
            return 'apply';

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getTraineeApplyByJobId($id)
    {
        $trainee_id = auth()->guard('trainee')->user()->id ?? auth()->guard('sanctum')->user()->id;
        return $this->model->where('trainee_id', $trainee_id)->where('job_id', $id)->where('apply_type', TypeTraineeApply::APPLY->value)->first();

    }

    public function getTraineeMatchedByJobId($id)
    {
        $trainee_id = auth()->guard('trainee')->user()->id ?? auth()->guard('sanctum')->user()->id;
        return $this->model->where('trainee_id', $trainee_id)->where('job_id', $id)->where('apply_type', TypeTraineeApply::JOB_MATCH->value)->first();

    }
}
