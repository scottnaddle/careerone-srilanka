<?php

namespace App\Services\Cgo;

use App\Contracts\Services\CounselingServiceInterface;
use App\Enums\CgoCounselingStatusEnums;
use App\Enums\CgoCounselingTypeEnums;
use App\Jobs\AssignCounselingSession;
use App\Jobs\ProcessAutoAsigneeOfCGO;
use App\Models\CgoCounseling;
use App\Models\CgoCounselingAssignHistory;
use App\Models\CgoUser;
use App\Models\CounselingField;
use App\Models\TraineeUser;
use App\Services\Trainee\NotificationManager as NotificationforTrainee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Cgo\NotificationManager;
use Illuminate\Support\Facades\Schema;
class CounselingService implements CounselingServiceInterface {
    protected object $model;
    protected  $notificationManager;
    protected $counselingAssignHistory;
    protected $notificationforTrainee;
    public function __construct(CgoCounseling $model, CgoCounselingAssignHistory $counselingAssignHistory, NotificationManager $notificationManager, NotificationforTrainee $notificationforTrainee)
    {
        $this->model = $model;
        $this->counselingAssignHistory = $counselingAssignHistory;
        $this->notificationManager = $notificationManager;
        $this->notificationforTrainee= $notificationforTrainee;
    }

    public function autoAssignCounseling($counseling)
    {
        $deadlineDate = Carbon::parse($counseling->available_time)->startOfDay();  // Parse as Carbon instance
        $currentDate = Carbon::today();  // Current date as Carbon instance

        $shift = $counseling->shift;
        $shiftSession = ($shift == 'AM') ? 1 : 2;
        $currentSession = (Carbon::now()->format('A') == 'AM') ? 1 : 2;

        if ($currentDate->greaterThan($deadlineDate) || (($shift!=null) && $currentDate->equalTo($deadlineDate) && $currentSession > $shiftSession)) {
            DB::table('cgo_counselings')
                ->where('id', $counseling->id)
                ->update([
                    'status'=>getCodeIdByStringEn('counselling_status', 'cancel')
                ]);
            return [
                'status' => 'error',
                'message' => 'Deadline for counseling has passed.',
                'code' => 500
            ];
        }
        $deniedUserIds = DB::table('cgo_counseling_assign_histories')
            ->where('counseling_id', $counseling->id)
            ->pluck('assignee_from')
            ->filter()
            ->flatMap(function ($item) {
                return json_decode($item, true);
            })
            ->toArray();
        if (is_null($shift)) {
            $dateRange = Carbon::today()->toDateString();
            $endDate = $deadlineDate->toDateString();
            $counselingCounts = DB::table('cgo_counselings')
                ->select(DB::raw('DATE(available_time) as date, COUNT(*) as count'))
                ->whereDate('available_time', '>=', $dateRange)
                ->whereDate('available_time', '<=', $endDate)
                ->groupBy('date')
                ->orderBy('count', 'asc')
                ->get();
            $leastCounselingDate = $counselingCounts->isNotEmpty() ? $counselingCounts->first()->date : null;
            if (!$leastCounselingDate) {
                return [
                    'status' => 'error',
                    'message' => 'No available dates for counseling.',
                    'code' => 500
                ];
            }
            $availableCgoUsers = DB::table('cgo_users')
            ->select('cgo_users.*', DB::raw('COUNT(cc.id) as counseling_count'))
            ->leftJoin('institutes', 'institutes.id', '=', 'cgo_users.institute_id')
            ->leftJoin('cgo_counseling_assign_histories', 'cgo_users.id', '=', 'cgo_counseling_assign_histories.assignee_to')
            ->leftJoin('cgo_counselings as cc', function ($join) use ($leastCounselingDate) {
                $join->on('cgo_counseling_assign_histories.counseling_id', '=', 'cc.id')
                    ->whereDate('cc.available_time', '=', $leastCounselingDate);
            })
            ->where('institutes.dist_id', $counseling->location)
            ->whereNotIn('cgo_users.id', $deniedUserIds)
            ->groupBy('cgo_users.id')
            ->orderBy('counseling_count', 'asc')
            ->get();
        } else {
            $availableCgoUsers = DB::table('cgo_users')
                ->leftJoin('institutes', 'institutes.id', '=', 'cgo_users.institute_id')
                ->select('cgo_users.*', DB::raw('COUNT(cc.id) as counseling_count'))
                ->leftJoin('cgo_counseling_assign_histories', 'cgo_users.id', '=', 'cgo_counseling_assign_histories.assignee_to')
                ->leftJoin('cgo_counselings as cc', function ($join) use ($shift, $deadlineDate) {
                    $join->on('cgo_counseling_assign_histories.counseling_id', '=', 'cc.id')
                        ->where('cc.shift', '=', $shift)
                        ->whereDate('cc.available_time', '=', $deadlineDate);
                })
                ->where('institutes.dist_id', $counseling->location)
                ->whereNotIn('cgo_users.id', $deniedUserIds)
                ->groupBy('cgo_users.id')
                ->orderBy('counseling_count', 'asc')
                ->get();
        }
        $availableCgoUsers = $availableCgoUsers->filter(function ($user) {
            return $user->counseling_count < 2;
        });
        // while (true) {
            // $excludedUserIds = DB::table('cgo_users')
            //     ->leftJoin('institutes', 'institutes.id', '=', 'cgo_users.institute_id')
            //     ->join('cgo_counseling_assign_histories', 'cgo_users.id', '=', 'cgo_counseling_assign_histories.assignee_to')
            //     ->join('cgo_counselings', 'cgo_counseling_assign_histories.counseling_id', '=', 'cgo_counselings.id')
            //     ->where('cgo_counselings.available_time', '=', $availableTime)
            //     ->where('institutes.dist_id', $counseling->location)
            //     ->pluck('cgo_users.id')
            //     ->toArray();

            // $deniedUserIds = DB::table('cgo_counseling_assign_histories')
            //     ->where('counseling_id', $counseling->id)
            //     ->pluck('assignee_from')
            //     ->filter()
            //     ->flatMap(function ($item) {
            //         return json_decode($item, true);
            //     })
            //     ->toArray();

            // $excludedUserIds = array_merge($excludedUserIds, $deniedUserIds);
            // $cgoUsers = DB::table('cgo_users')
            //      ->leftJoin('institutes', 'institutes.id', '=', 'cgo_users.institute_id')
            //      ->where('institutes.dist_id', $counseling->location)
            //     ->whereNotIn('cgo_users.id', $excludedUserIds)
            //     ->get();
            if ($availableCgoUsers->isNotEmpty()) {
                $counselingRecord = DB::table('cgo_counseling_assign_histories')
                    ->where('counseling_id', $counseling->id)
                    ->first();

                    $assigneeFrom = json_decode($counselingRecord->assignee_from, true);

                    if (!is_array($assigneeFrom)) {
                        $assigneeFrom = [];
                    }
                    if ($counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'Guidance without reservation') && count($assigneeFrom) >= 3) {

                        return [
                            'status' => 'error',
                            'message' => 'Reached limit cannot cancel or assign to others.',
                            'code' => 500
                        ];
                    }


                $assigneeFrom[] = $counselingRecord->assignee_to;

                $firstUser = $availableCgoUsers->first();
                $cgoUser= CgoUser::find($firstUser->id);
                DB::table('cgo_counseling_assign_histories')
                    ->where('counseling_id', $counseling->id)
                    ->update([
                        'assignee_from' => json_encode($assigneeFrom),
                        'assignee_to' => $firstUser->id,
                    ]);
                if($counseling->trainee_id){
                    $trainee_user= TraineeUser::find($counseling->trainee_id);
                    $counseling['user_name_trainee_online']= $trainee_user->full_name;
                }else{
                    $counseling['user_name_trainee_online']='Trainee';
                }
                $this->notificationManager->sendAllocatingAounselingNotificationtoCgo($cgoUser, $counseling);
                return [
                    'status' => 'success',
                    'message' => 'Counseling successfully delivered to: ' . $firstUser->email,
                    'code' => 200
                ];
            } else {
                DB::table('cgo_counselings')
                ->where('id', $counseling->id)
                ->update([
                    'status'=>getCodeIdByStringEn('counselling_type', 'cancel')
                ]);
                return [
                    'status' => 'error',
                    'message' => 'No available users for the specified time slot. The counseling will be canceled.',
                    'code' => 500
                ];
            }
        // }
    }




    public function getListOfCounseling()
    {
        return $this->model->select()
            ->with('traineeUser')
            ->get();
    }

    public function getListsOfCounselingByCgoId($request, $id, $numberRecord = null)
    {

        $listCounseling =  $this->model->query()->orderBy('cgo_counselings.available_time', 'desc')
            ->with('traineeUser')
            ->join('cgo_counseling_assign_histories as cah', 'cah.counseling_id', '=', 'cgo_counselings.id')
            ->where('cgo_counselings.status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
            ->where('cah.assignee_to', $id);

//        if ($request->has('search_query')) {
//            $listCounseling->where('cgo_counselings.title', 'ILIKE', '%' . $request->search_query . '%');
//        }
        //Search by trainee name
        if ($request->has('search_query')) {
            $searchQuery = $request->input('search_query');

            $listCounseling->whereHas('traineeUser', function ($query) use ($searchQuery) {
                $query->where('full_name', 'ILIKE', '%' . $searchQuery . '%');
            });
            $listCounseling->orWhere('trainee_offline_firstname', 'ILIKE', '%'.$searchQuery.'%');
            $listCounseling->orWhere('trainee_offline_lastname', 'ILIKE', '%'.$searchQuery.'%');
        }

        if ($request->has('status') && $request->status !== 'all') {
            $listCounseling->where('cgo_counselings.status', $request->status);
        }

        if ($request->has('type') && $request->type !== 'all') {
            if ($request->type == 'offline') {
                $listCounseling->whereIn('cgo_counselings.counseling_type', ['1', '3']);
            }else {
                $listCounseling->where('cgo_counselings.counseling_type', $request->type);
            }
        }
        if ($request->has('startdate') && $request->has('enddate') && !empty($request->startdate) && !empty($request->enddate)) {
            $startdate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->startdate)->format('Y-m-d');
            $enddate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->enddate)->format('Y-m-d');
            $listCounseling->where(DB::raw('cgo_counselings.available_time::date'), '>=', $startdate)
            ->where(DB::raw('cgo_counselings.available_time::date'), '<=', $enddate);

        }

        if ($numberRecord) {
            if ($numberRecord == 'all') {
                return $listCounseling->get();
            }
            return $listCounseling->take($numberRecord)->get();
        }

        return $listCounseling->paginate(10)->appends($request->query());
    }

    public function getCounselingById($id)
{
    if (!$id) {
        return response()->json(['error' => 'Invalid ID'], 400);
    }
    $counseling = $this->model->select('cgo_counselings.*')
        ->with('traineeUser')
        ->with('district')
        ->with('counselingAttachment')
        ->where('cgo_counselings.id', $id)
        ->first();
    if (!$counseling) {
        return response()->json(['error' => 'Counseling not found'], 404);
    }
    if ($counseling->trainee_id) {
        $counseling = $this->model->select('cgo_counselings.*')
            ->join('trainee_users', 'trainee_users.id', '=', 'cgo_counselings.trainee_id')
//            ->join('n_v_q_levels', 'n_v_q_levels.id', '=', 'trainee_users.nvq_id') //trainee have more than 1 nvq
//            ->join('occupations', 'trainee_users.occupation_id', '=', 'occupations.id') //remove occupation
            ->with('traineeUser')
            ->with('counselingAttachment')
            ->with('district')
            ->where('cgo_counselings.id', $id)
            ->first();
    }
    if (!$counseling) {
        return response()->json(['error' => 'Counseling not found'], 404);
    }
    $feedback = !empty($counseling->feedback_message)
        ? json_decode($counseling->feedback_message, true, 512, JSON_THROW_ON_ERROR)
        : [];

    $missingFeedback = $this->getMissingFeedback($feedback);
    $counseling->missing_feedback = $missingFeedback;

    return $counseling;
}


    public function getMissingFeedback($feedback)
    {
        $fullFeedbackAttributes = ["organized", "friendly", "detailed", "kind", "good_service"];
        $missingFeedbackAttributes = array_diff($fullFeedbackAttributes, $feedback);

        return $missingFeedbackAttributes;
    }

    public function storeOfflineCounseling($request)
    {
        $availableTimeString = $request->available_date;
//        $availableTimeString = $request->available_hour . ':' . $request->available_minute . ' ' . $request->available_date;
        $availableTime = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $availableTimeString);
        $traineeMembership = TraineeUser::where('nic', $request->trainee_nic)->first();
        $counseling = $this->model->create([
            'title' => $request->title,
            'detail_information' => $request->detail_information,
            'counseling_type' =>  $request->guidance_type,
            'counseling_field_id' => $request->counseling_field_id,
            'available_time' => $availableTime,
            'trainee_nic' => $request->trainee_nic,
            'trainee_id' => $traineeMembership ? $traineeMembership->id : null,
            'registration_date' => now(),
            'location'=> Auth::guard('cgo')->user()->district_id,
            'institute_id' => CgoUser::query()->where('id', Auth::guard('cgo')->user()->id)->firstOrFail()->institute_id,
            'status' => getCodeIdByStringEn('counselling_status', 'confirm'),
            'trainee_offline_firstname' => $request->trainee_offline_firstname,
            'trainee_offline_lastname' => $request->trainee_offline_lastname,
            'trainee_offline_mobile' => $request->trainee_offline_mobile,
            'trainee_offline_institute' => $request->trainee_offline_institute,
            'trainee_offline_email' => $request->trainee_offline_email,
        ]);
        if($traineeMembership){
            $this->notificationforTrainee->sendNotificationCgoConfirmCounselingToTrainee($traineeMembership, $counseling);
        }
        $this->counselingAssignHistory->create([
            'counseling_id' => $counseling->id,
            'assignee_to' => Auth::guard('cgo')->user()->id,
            'time' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $counseling;
    }

    public function getListsOfCounselingField()
    {
        return CounselingField::all();
    }

//    public function storeResultCounseling($request, $id)
//    {
//        $counseling = $this->model->find($id);
//        if(!empty( $counseling->trainee_id)){
//            $trainee = TraineeUser::find($counseling->trainee_id);
//             $this->notificationManager->CgoSubmitResultSendNotificationToTrainee($trainee,$counseling);
//        }
//
//        return $counseling->update([
//            'result' => $request->result,
//            'suggested_institutes' => $request->suggested_institutes,
//            'suggested_nvq_courses' => $request->suggested_nvq_courses,
//            'suggested_tvec_courses' => $request->suggested_tvec_courses,
//        ]);
//    }
    public function storeResultCounseling($request, $id)
    {
        $counseling = $this->model->find($id);

        // Check if the cgo_counselings table contains the required columns
        $hasSuggestedInstitutes = Schema::hasColumn('cgo_counselings', 'suggested_institutes');
        $hasSuggestedNvqCourses = Schema::hasColumn('cgo_counselings', 'suggested_nvq_courses');
        $hasSuggestedTvecCourses = Schema::hasColumn('cgo_counselings', 'suggested_tvec_courses');

        if (!empty($counseling->trainee_id)) {
            $trainee = TraineeUser::find($counseling->trainee_id);
            $this->notificationManager->CgoSubmitResultSendNotificationToTrainee($trainee, $counseling);
        }

        // Prepare the data to update
        if ($request->temporaty_save_flag == 'true') {
            $save_draf = true;
        }else {
            $save_draf = false;
        }
        $updateData = [
            'result' => $request->result,
            'temporary_save' => $save_draf
        ];

        // Conditionally add columns to the update data
        if ($hasSuggestedInstitutes && $request->has('suggested_institutes')) {
            $updateData['suggested_institutes'] = $request->suggested_institutes;
        }
        if ($hasSuggestedNvqCourses && $request->has('suggested_nvq_courses')) {
            $updateData['suggested_nvq_courses'] = $request->suggested_nvq_courses;
        }
        if ($hasSuggestedTvecCourses && $request->has('suggested_tvec_courses')) {
            $updateData['suggested_tvec_courses'] = $request->suggested_tvec_courses;
        }

        // Update the counseling record
        return $counseling->update($updateData);
    }

    public function updateCounselingStatus( $id, $status)
    {
        $counseling = $this->model->find($id);

//        if ($status instanceof \UnitEnum) {
//            $status = $status->value;
//        }

        return $counseling->update([
            'status' => $status,
        ]);
    }

    public function rejectCounseling($request, $id)
    {
        try {
            $counseling = CgoCounseling::query()->find($id);

            if (!$counseling) {
                return [
                    'status' => 'error',
                    'message' => 'Counseling not found',
                ];
            }
            switch ($counseling->status) {
                case getCodeIdByStringEn('counselling_status', 'confirm'):
                    return [
                        'status' => 'error',
                        'message' => 'Cannot reject counseling that is already confirmed',
                    ];
                case getCodeIdByStringEn('counselling_status', 'completed'):
                    return [
                        'status' => 'error',
                        'message' => 'Cannot reject counseling that is already completed',
                    ];
            }

            // if ($counseling->status === CgoCounselingStatusEnums::REQUEST->value) {
                try {

                    // $queueId = $this->autoAssignCounseling($counseling);
                    ProcessAutoAsigneeOfCGO::dispatch( $counseling->id)->delay(now()->addSeconds(5));
                    return [
                        'status' => 'success',
                        'message' => 'Success',
                        'data' => $counseling,
                    ];
                    // if (!$queueId) {
                    //     return [
                    //         'status' => 'error',
                    //         'message' => 'Cannot assign counseling',
                    //         'code'=>500
                    //     ];
                    // }
                    // $counseling->status = CgoCounselingStatusEnums::RE_ASSIGN->value;
                    $counseling->save();

                    // return [
                    //     'status' => $queueId['status'],
                    //     'message' => $queueId['message'],
                    //     'code'=> 200
                    // ];
                } catch (\Exception $e) {

                    return [
                        'status' => 'error',
                        'message' => $e->getMessage(),
                    ];
                }
            // }
            return [
                'status' => 'error',
                'message' => 'Failed to cancel counseling',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }


//    public function getListsOfCounselingStatusEnum()
//    {
//        $listStatusEnum = CgoCounselingStatusEnums::cases();
//        array_pop($listStatusEnum);
//
//        return $listStatusEnum;
//    }
//
//    public function getListsOfCounselingTypeEnum()
//    {
//        return CgoCounselingTypeEnums::cases();
//    }

    public function getListsOfScheduleCounselingByCgoId($id,$date=null)
    {

        $recentDate = $date ?? now();
        $currentDate = Carbon::parse($recentDate);
        $weeklyCounseling = $this->getWeeklyCounselingByCgoId($id, $recentDate);
        $monthlyCounseling = $this->getMonthlyCounselingByCgoId($id, $recentDate);

        $weeklyCounseling = $weeklyCounseling->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->available_time)->format('Y-m-d');
        });

        $weeklyCounseling = $this->addFreeDateToWeeklySchedule($weeklyCounseling, $this->getListsOfWorkingDayOfWeek($recentDate));

        return [
            'weekly' => $weeklyCounseling,
            'monthly' => $monthlyCounseling,
            'current_month'=>$currentDate->month,
            'current_year'=>$currentDate->year
        ];
    }

    public function getWeeklyCounselingByCgoId( $id, $recentDate = null)
    {
        if (!$recentDate) {
            $recentDate = now();
        }

        if (!$recentDate instanceof Carbon) {
            $recentDate = Carbon::parse($recentDate);
        }

        //get counseling just at working day of week

        $listCounseling =  $this->model->query()->orderBy('cgo_counselings.available_time', 'desc')
            ->with('traineeUser')
            ->join('cgo_counseling_assign_histories as cah', 'cah.counseling_id', '=', 'cgo_counselings.id')
            ->where('cgo_counselings.status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
            ->where('cah.assignee_to', $id);

        $startOfWeek = $recentDate->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $recentDate->copy()->endOfWeek(Carbon::FRIDAY);

        // loop through the week
        $currentWeek = [];
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            $currentWeek[] = [
                'date' => $date->format('Y-m-d'),
            ];
        }
         $listCounseling->whereBetween(DB::raw('cgo_counselings.available_time::date'), [reset($currentWeek)['date'],end($currentWeek)['date']]);

        return $listCounseling->get();
    }

    public function getMonthlyCounselingByCgoId( $id, $currentDate = null)
    {
        if (!$currentDate instanceof Carbon) {
            $currentDate = Carbon::parse($currentDate);
        }

        $listCounseling = $this->model->query()
                                      ->selectRaw('
                                            DATE(cgo_counselings.available_time) as day,
                                            cgo_counselings.status,
                                            COUNT(*) as count
                                        ')
                                      ->with('traineeUser')
                                      ->join('cgo_counseling_assign_histories as cah', 'cah.counseling_id', '=',
                                          'cgo_counselings.id')
                                      ->where('cah.assignee_to', $id)
                                      ->whereMonth('cgo_counselings.available_time', $currentDate->month)
                                      ->groupBy('day', 'cgo_counselings.status')
                                      ->get();

        return $listCounseling;
    }

    public function getListsOfWorkingDayOfWeek($currentDate = null)
    {
        if (!$currentDate) {
            $currentDate = now();
        }

        if (!$currentDate instanceof Carbon) {
            $currentDate = Carbon::parse($currentDate);
        }

        $startOfWeek = $currentDate->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $currentDate->copy()->endOfWeek(Carbon::FRIDAY);

        $listWorkingDayCurrentWeek = [];
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            $listWorkingDayCurrentWeek[] = [
                'dayName' => $date->format('D'),
                'dayNumber' => $date->day,
                'date' => $date->format('Y-m-d'),
            ];
        }

        return $listWorkingDayCurrentWeek;
    }

    public function addFreeDateToWeeklySchedule($listScheduleCounseling, $listWorkingDayCurrentWeek)
{
    $listScheduleCounselingByStatus = [];

    foreach ($listWorkingDayCurrentWeek as $workingDay) {
        // Initialize the structure for each working day
        $listScheduleCounselingByStatus[$workingDay['date']] = [
            "items" => [],
            "date"  => $workingDay['date'],
            "count_by_status" => [],
        ];

        if (empty($listScheduleCounseling[$workingDay['date']])) {
            continue;
        }

        foreach ($listScheduleCounseling[$workingDay['date']] as $item) {
            $status = $item->status; // Assuming 'status' is a property of $item

            // Count items by status
            if (!isset($listScheduleCounselingByStatus[$workingDay['date']]['count_by_status'][$status])) {
                $listScheduleCounselingByStatus[$workingDay['date']]['count_by_status'][$status] = 0;
            }

            // Limit to 3 items per status
            if ($listScheduleCounselingByStatus[$workingDay['date']]['count_by_status'][$status] >= 3) {
                continue;
            }

            $listScheduleCounselingByStatus[$workingDay['date']]['items'][] = $item;
            $listScheduleCounselingByStatus[$workingDay['date']]['count_by_status'][$status]++;
        }
    }

    return $listScheduleCounselingByStatus;
}

}
