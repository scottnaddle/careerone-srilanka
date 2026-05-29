<?php

namespace App\Http\Controllers;

use App\Enums\JobStatusEnum;
use App\Enums\TypeTraineeApply;
use App\Models\OJT;
use App\Models\OJTMatch;
use App\Models\OjtTraineeApply;
use App\Models\TraineeUser;
use App\Services\Cgo\NotificationManager;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OJTMatchController extends Controller
{
    protected $notificationManager;
    public function __construct(NotificationManager $notificationManager)
    {
        $this->middleware('company.auth');
        $this->notificationManager = $notificationManager;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $isMatch = OJTMatch::where([
            'trainee_id' => $data['trainee_id'],
            'ojt_id' => $data['ojt_id']
        ])->first();

        $isOJTTraineeApply = OjtTraineeApply::where([
            'trainee_id' => $data['trainee_id'],
            'ojt_id' => $data['ojt_id'],
            'apply_type' => TypeTraineeApply::OJT_MATCH
        ])->first();

        $ojt = OJT::findOrFail($data['ojt_id']);

        if ($isMatch || $isOJTTraineeApply) {
            try {
                if ($isMatch) {
                    $isMatch->delete();
                }

                OjtTraineeApply::where([
                    'trainee_id' => $data['trainee_id'],
                    'ojt_id' => $data['ojt_id'],
                    'apply_type' => TypeTraineeApply::OJT_MATCH
                ])->delete();

                if ($request->redirect) {
                    return redirect()->route('cgo.job-support.ojt-list.trainee-match', ['slug' => $ojt->slug]);
                }

                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'You have unmatched this trainee!',
                    'action' => 'unmatch'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'code' => 500,
                    'message' => 'Unmatch failed!',
                    'error' => $e->getMessage()
                ]);
            }
        }

        try {
            $data['matched_time'] = now();
            $ojtMatch = OJTMatch::create($data);
            $traineeApply = new OjtTraineeApply();
            $traineeApply->ojt_id = $data['ojt_id'];
            $traineeApply->trainee_id = $data['trainee_id'];
            $traineeApply->apply_time = now();
            $traineeApply->read = null;
            $traineeApply->selected = null;
            $traineeApply->employeed = null;
            $traineeApply->selected_by = null;
            $traineeApply->matched_by = $data['matched_by'];
            $traineeApply->apply_type = TypeTraineeApply::OJT_MATCH;
            $traineeApply->save();

            $this->notificationManager->sendNotificationOJTMatchToTrainee($ojt,$traineeApply);
            $this->notificationManager->sendNotificationOJTMatchToCompany($traineeApply);
            if ($request->redirect) {
                return redirect()->route('cgo.job-support.ojt-list.list-matched', ['slug' => $ojt->slug]);
            }

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'You have matched this trainee!',
                'action' => 'match'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'code' => 500,
                'message' => 'Match failed!',
                'error' => $e->getMessage()
            ]);
        }
    }
     /**
     * Update status read trainee CV
     *
     * @param Request $request
     * @return JsonResponse
     */
public function updateStatusReadTraineeCV(Request $request, $trainee_id = null, $ojt_id = null)
{
    if (!$trainee_id || !$ojt_id) {
        $trainee_id = $request->input('trainee_id');
        $ojt_id = $request->input('ojt_id');
    }
    if (!$trainee_id || !$ojt_id) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing trainee_id or ojt_id'
        ], 400);
    }

    try {
        $affected = OjtTraineeApply::where('trainee_id', $trainee_id)
            ->where('ojt_id', $ojt_id)
            ->update(['read' => now()]);

        if ($affected === 0) {
            return response()->json([
                'status' => 'warning',
                'message' => 'No matching record found to update'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Update status read CV success'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error when updating status read CV',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Selected trainee apply job vacancy
     *
     * @param Request $request
     * @return JsonResponse
     */
public function selectedTraineeApply(Request $request)
{
    try {
        $trainee_apply_id = $request->request->get('trainee_apply_id');
        $traineeApply = OjtTraineeApply::with(['ojt', 'user'])->find($trainee_apply_id);

        if (!$traineeApply) {
            return response()->json(['status' => 'error', 'message' => 'Record not found']);
        }

        $trainee_id = $traineeApply->trainee_id;
        $ojt_id = $traineeApply->ojt_id;
        $ojt = OJT::find($ojt_id);

        $this->notificationManager->sendSelectedTraineeOJTNotification($ojt, $traineeApply);
        $ojtMatchApply = OjtTraineeApply::with('matchedBy')
            ->where('trainee_id', $trainee_id)
            ->where('ojt_id', $ojt_id)
            ->where('apply_type', 'ojt_match')
            ->first();

        if ($ojtMatchApply) {
            $this->notificationManager->sendSelectedTraineeOJTNotificationToCGO($ojt, $ojtMatchApply);
        }
        OjtTraineeApply::where('trainee_id', $trainee_id)
            ->where('ojt_id', $ojt_id)
            ->update([
                'selected' => now(),
                'selected_by' => auth('company')->user()->id,
                'unselect_at' => null,
                'rejected_at' => null
            ]);

        return response()->json(['status' => 'success', 'message' => 'Selected trainee apply success']);
    } catch (\Exception $e) {

        return response()->json(['status' => 'error', 'message' => 'Error when selected trainee apply,'.$e->getMessage()]);
    }
}



    /**
     * Unselected trainee apply job vacancy
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unselectedTraineeApply(Request $request)
    {

        try {
            $trainee_apply_id = $request->request->get('trainee_apply_id');
            $traineeApply = OjtTraineeApply::find($trainee_apply_id);
            if (!$traineeApply) {
                return response()->json(['status' => 'error', 'message' => 'Record not found']);
            }
            $trainee_id = $traineeApply->trainee_id;
            $ojt_id = $traineeApply->ojt_id;
            $trainee=$traineeApply->user;
            OjtTraineeApply::where('trainee_id', $trainee_id)
                ->where('ojt_id', $ojt_id)
                ->update(['selected' => null, 'selected_by' => null, 'unselect_at' => now(),'rejected_at' => null]);

            $ojtMatchApplies = OjtTraineeApply::with('matchedBy')
                ->where('trainee_id', $trainee_id)
                ->where('ojt_id', $ojt_id)
                ->whereIn('apply_type', ['apply', 'ojt_match'])
                ->get();

            foreach ($ojtMatchApplies as $apply) {

                if ($apply->apply_type === 'apply') {
                    $this->notificationManager->sendUnSelecrTraineeNotificationToTrainee($trainee, $apply);
                } elseif ($apply->apply_type === 'ojt_match') {
                    $this->notificationManager->sendUnSelecrTraineeNotificationToCGO($trainee, $apply);
                }
            }


            return response()->json(['status' => 'success', 'message' => 'Unselected trainee apply success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error when unselected trainee apply']);
        }
    }

    /**
     * Employeed trainee apply job vacancy
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function employeedTraineeApply(Request $request)
{
    try {
        $trainee_apply_id = $request->input('trainee_apply_id');
        $traineeApply = OjtTraineeApply::with(['ojt', 'user'])->find($trainee_apply_id);

        if (!$traineeApply) {
            return response()->json(['status' => 'error', 'message' => 'Record not found']);
        }

        $trainee_id = $traineeApply->trainee_id;
        $ojt_id = $traineeApply->ojt_id;

        OjtTraineeApply::where('trainee_id', $trainee_id)
            ->where('ojt_id', $ojt_id)
            ->update(['employeed' => now(),'rejected_at' => null,'unselect_at' => null]);
        $ojt = OJT::find($ojt_id);

        if ($ojt) {
            $countEmployeed = OjtTraineeApply::where('ojt_id', $ojt_id)
                ->whereNotNull('employeed')
                ->count();

            if ($countEmployeed == $ojt->number_of_recruitments) {
                $ojt->status = JobStatusEnum::COMPLETED->value;
                $ojt->save();
            }
            $this->notificationManager->sendEmployeedTraineeNotification($ojt, $traineeApply);
            $ojtMatchApply = OjtTraineeApply::with('matchedBy')
                ->where('trainee_id', $trainee_id)
                ->where('ojt_id', $ojt_id)
                ->where('apply_type', 'ojt_match')
                ->first();

            if ($ojtMatchApply) {
                $this->notificationManager->sendEmployeedTraineeNotificationToCGO($ojt, $ojtMatchApply);
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Trainee has been successfully employed.']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Error when employeed trainee apply']);
    }
}

    public function unemployTraineeApply(Request $request)
{
    try {
        $trainee_apply_id = $request->input('trainee_apply_id');
        $traineeApply = OjtTraineeApply::find($trainee_apply_id);
        if (!$traineeApply) {
            return response()->json(['status' => 'error', 'message' => 'Record not found']);
        }
        $trainee_id = $traineeApply->trainee_id;
        $ojt_id = $traineeApply->ojt_id;
        OjtTraineeApply::where('trainee_id', $trainee_id)
        ->where('ojt_id', $ojt_id)
        ->update(['employeed' => NULL,'rejected_at' => now()]);
        $ojt = OJT::where('id', $ojt_id)->first();
        if ($ojt) {
            $countEmployeed = OjtTraineeApply::where('ojt_id', $ojt_id)->whereNotNull('employeed')->count();
            if ($countEmployeed < $ojt->number_of_recruitments) {
                $ojt->status = JobStatusEnum::PROGRESS->value;
                $ojt->save();
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Trainee has been unapproved.']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Error when unapproving trainee.']);
    }
}
    public function ojtTraineeInformation(Request $request,$ojt, $trainee)
    {
        $ojt = OJT::where(['slug' => $ojt])->first();
        $trainee = TraineeUser::where(['id' => $trainee])->first();
        $traineeApply = OjtTraineeApply::where('trainee_id', $trainee->id)
        ->where('ojt_id', $ojt->id)
        ->get();
        $this->updateStatusReadTraineeCV($trainee, $ojt);
        return view('company.job-support.ojt-list.trainee-information')->with(['trainee' => $trainee, 'ojt' => $ojt,'traineeApply' => $traineeApply]);
    }
}
