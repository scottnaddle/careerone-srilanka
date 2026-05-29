<?php

namespace App\Http\Controllers\Api;

use App\Enums\JobStatusEnum;
use App\Enums\Trainee\ApplyTypeEnums;
use App\Enums\TypeTraineeApply;
use App\Http\Controllers\Controller;
use App\Models\TraineeApply;
use App\Models\TraineeMatch;
use App\Models\TraineeUser;
use Exception;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Services\Trainee\NotificationManager;
use Illuminate\Support\Facades\Auth;


class TraineeMatchController extends Controller
{


    protected $notificationManager;

    public function __construct( NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $data['match_time'] = now();
        $job_id = $data['job_id'];
        $job = Job::where('id', $job_id)->first();

        if (!$job) {
            response()->json(['status' => 'fail', 'code' => 500, 'message' => 'Job is not exist!']);
        }

        if (!$job->status) {
            response()->json(['status' => 'fail', 'code' => 500, 'message' => 'Job is closed, You cannot match this job!']);
        }

        $isExist = TraineeMatch::where(['trainee_id' => $data['trainee_id'], 'job_id' => $data['job_id']])->first();

        if ($isExist) {
            try {
                $isExist->delete();
                $traineeApply = TraineeApply::where('trainee_id', $data['trainee_id'])->where('job_id', $data['job_id'])->where('apply_type', TypeTraineeApply::JOB_MATCH)->first();
                if ($traineeApply) {
                    $traineeApply->delete();
                }
                if ($request->redirect) {
                    return redirect()->route('cgo.job-support.trainee-list.job-match', ['trainee' => $data['trainee_id']]);
                }
                return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have unmatched this trainee!', 'action' => 'unmatch']);
            } catch (ModelNotFoundException $e) {
                return response()->json(['status' => 'fail', 'code' => 201, 'message' => $e, 'action' => 'null']);
            };

        }
        $traineeMatch = TraineeMatch::create($data);
        $traineeApplyData = new TraineeApply();
        $traineeApplyData->job_id = $data['job_id'];
        $traineeApplyData->trainee_id = $data['trainee_id'];
        $traineeApplyData->apply_time = now();
        $traineeApplyData->read = null;
        $traineeApplyData->selected = null;
        $traineeApplyData->employeed = null;
        $traineeApplyData->selected_by = null;
        $traineeApplyData->apply_type = TypeTraineeApply::JOB_MATCH;
        $traineeUser= TraineeUser::find($data['trainee_id']);
        $job = Job::with('company')->find($data['job_id']);
        $this->notificationManager->matchJobNotificationOfCgo($traineeUser, $job);
        $traineeApplyData->save();
        if ($request->redirect) {
            return redirect()->route('cgo.job-support.trainee-list.job-match', ['trainee' => $data['trainee_id']]);
        }
        return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have matched this trainee!', 'action' => 'match']);
    }
}
