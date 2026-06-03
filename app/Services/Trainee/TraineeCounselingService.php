<?php

namespace App\Services\Trainee;

use App\Models\CgoCounseling;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Requests\Trainee\StoreTraineeCounseling;
use App\Enums\CgoCounselingTypeEnums;
use App\Enums\CgoCounselingStatusEnums;
use App\Models\CgoUser;
use App\Models\CounselingAttachment;
use App\Models\CgoCounselingAssignHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Contracts\Services\CounselingServiceInterface;
use App\Models\CategorySystem;
use App\Services\Cgo\NotificationManager;
use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\District;
use App\Models\CounselingField;
use App\Jobs\ProcessAutoAssignCounseling;

class TraineeCounselingService
{
    protected $notificationManager;
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    public function handleStore($request)
    {
        DB::beginTransaction();
        try {
            if ($request->bearerToken()) {
                $full_name = auth('sanctum')->user()->full_name;
                $nic = auth('sanctum')->user()->nic;
                $id = auth('sanctum')->user()->id;
            } else {
                $full_name = auth()->guard('trainee')->user()->full_name;
                $nic = auth()->guard('trainee')->user()->nic;
                $id = auth()->guard('trainee')->user()->id;
            }
            $counseling = new CgoCounseling();
            if (isset($request->am_pm)) {
                $counseling->shift = $request->am_pm;
            }
            $counseling->counseling_type = $request->counseling_check_status;
            $counseling->counseling_field_id = $request->counseling_field_id;
            $counseling->trainee_nic = $nic;
            $counseling->title = $request->title;
            $counseling->available_time = $request->available_date;
            $counseling->detail_information = $request->detail_information;
            $counseling->registration_date = now();
            $counseling->institute_id = $request->institute;
            $counseling->location = $request->districts;
            $counseling->status = CgoCounselingStatusEnums::REQUEST->value;
            $counseling->trainee_id = $id;
            $counseling->trainee_offline_firstname =  $full_name;
            $counseling->trainee_offline_lastname = " ";
            $counseling->save();

            if ($request->hasFile('trainee_attachment')) {
                $file = $request->file('trainee_attachment');
                $filePath = $file->store('images/counseling', 'public');

                CounselingAttachment::create([
                    'counseling_id' => $counseling->id,
                    'file_name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }

            $couneseling_history = CgoCounselingAssignHistory::create([
                'counseling_id' => $counseling->id,
                'assignee_to' => 0,
                'time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $data = $request->only(['counseling_check_status', 'am_pm', 'counseling_field_id', 'title', 'available_date', 'detail_information', 'institute', 'districts']);
            ProcessAutoAssignCounseling::dispatch($data, $counseling->id, $couneseling_history->id)->delay(now()->addSeconds(5));


            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Success',
                'data' => $counseling,
            ];
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ];
        }
    }

    public function autoAssignCounseling($request, $counseling, $counseling_history_id)
    {
        try {
            $currentDate = Carbon::now();
            $shift = $counseling->shift;
            if (!empty($counseling->trainee_offline_firstname)) {
                $fullName = $counseling->trainee_offline_firstname;
            } else {
                $fullName = $request->bearerToken()
                    ? auth('sanctum')->user()->fullName
                    : auth()->guard('trainee')->user()->fullName;
            }


            $deadlineDate = Carbon::parse($counseling->available_time);
            // if ($currentDate->greaterThanOrEqualTo($deadlineDate)) {
            //     return [
            //         'status' => 'error',
            //         'message' => 'Deadline for counseling has passed.',
            //         'code' => 500
            //     ];
            // }
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
                    $counseling->status = getCodeIdByStringEn('counselling_status', 'cancel');
                    $counseling->save();
                    return [
                        'status' => 'cancel',
                        'message' => 'No available dates for counseling.',
                        'code' => 200
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
                    ->groupBy('cgo_users.id')
                    ->orderBy('counseling_count', 'asc')
                    ->get();
            }
            $availableCgoUsers = $availableCgoUsers->filter(function ($user) {
                return $user->counseling_count < 2;
            });
            if ($availableCgoUsers->isNotEmpty()) {
                $firstUser = $availableCgoUsers->first();
                DB::table('cgo_counseling_assign_histories')
                    ->where('id', $counseling_history_id)
                    ->update(['assignee_to' => $firstUser->id]);

                $userCgo = CgoUser::find($firstUser->id);
                $counseling['user_name_trainee_online'] = $fullName;
                $this->notificationManager->sendAllocatingAounselingNotificationtoCgo($userCgo, $counseling);
                return [
                    'status' => 'success',
                    'message' => 'Counseling successfully delivered to: ' . $firstUser->email,
                    'code' => 200
                ];
            } else {
                DB::table('cgo_counseling_assign_histories')
                    ->where('id', $counseling_history_id)
                    ->update(['assignee_to' => 0]);
                $counseling->status = getCodeIdByStringEn('counselling_status', 'cancel');
                $counseling->save();
                return [
                    'status' => 'cancel',
                    'message' => 'No available users for the specified shift.',
                    'code' => 200
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'code' => 500
            ];
        }
    }
    public function getCounselingHistory(Request $request)
    {
        if ($request->bearerToken()) {
            $id_user = auth('sanctum')->user();
        } else {
            $id_user = auth()->guard('trainee')->user();
        }
//        $id_user = Auth::guard(activeGuard())->user()->id;
        $id_user = $id_user->id;

        if ($id_user) {
            $listCounselingHistory = CgoCounseling::query()
                ->select('cgo_counselings.*', 'cgo_users.first_name', 'cgo_users.last_name')
                ->with('counselingAttachment')
                ->orderBy('cgo_counselings.available_time', 'desc')
                ->leftJoin('cgo_counseling_assign_histories as cah', 'cah.counseling_id', '=', 'cgo_counselings.id')
                ->leftJoin('cgo_users', 'cgo_users.id', '=', 'cah.assignee_to')
                ->where('cgo_counselings.trainee_id', $id_user)
                ->paginate(10)
                ->appends($request->query());
                $listCounselingHistory->getCollection()->transform(function ($item) {
                    if (!empty($item->counselingAttachment && !empty($item->counselingAttachment[0]->path))) {
                        $item->counselingAttachment[0]->path = asset('storage/' .$item->counselingAttachment[0]->path);
                    }
                    return $item;
                });

            $missingFeedback = $this->getMissingFeedback();
            $listCounselingHistory->missing_feedback = $missingFeedback;

            return ['data' => $listCounselingHistory];
        } else {
            return null;
        }
    }
    public function getMissingFeedback()
    {
        $fullFeedbackAttributes = ["organized", "friendly", "detailed", "kind", "good_service"];

        return $fullFeedbackAttributes;
    }
    public function getCounselingRequestData()
    {
        $instituteName = Institute::where('active_status', 'ILIKE', 'Active')->get();
        $districts = District::all();

        return compact('instituteName', 'districts');
    }
    public function getCounselingDetails(string $id)
    {
        return CgoCounseling::select('cgo_counselings.*', 'cgo_users.first_name', 'cgo_users.last_name')
            ->join('cgo_counseling_assign_histories as cah', 'cah.counseling_id', '=', 'cgo_counselings.id')
            ->join('cgo_users', 'cgo_users.id', '=', 'cah.assignee_to')
            ->with('traineeUser')
            ->with('district')
            ->with('counselingAttachment')
            ->find($id);
    }
    public function storeFeedbackData(CgoCounseling $cgoCounseling, Request $request)
    {
        $cgoCounseling->feedback = $request->rating;
        $cgoCounseling->trainee_feedback = $request->feedback_result;
        $cgoCounseling->feedback_message = json_encode($request->input('selected_buttons', []));
        $cgoCounseling->save();
    }
    public function handleEdit($request,$cgoCounseling)
    {
        DB::beginTransaction();

        try {
            if ($cgoCounseling->status != \App\Enums\CgoCounselingStatusEnums::REQUEST->value) {
                return [
                    'status' => 'error',
                    'message' => 'Cannot update when status is ' . \App\Enums\CgoCounselingStatusEnums::getCgoCounselingStatusName($cgoCounseling->status),
                ];
            }

            $cgoCounseling->fill([
                'shift' => $request->am_pm ?? $cgoCounseling->shift,
                'counseling_type' => $request->counseling_check_status,
                'counseling_field_id' => $request->counseling_field_id,
                'title' => $request->title,
                'available_time' => $request->available_date,
                'detail_information' => $request->detail_information,
                'institute_id' => $request->institute,
                'location' => $request->districts,
            ])->save();
            if ($request->hasFile('trainee_attachment')) {
                $file = $request->file('trainee_attachment');
                $filePath = $file->store('images/counseling', 'public');

//                CounselingAttachment::create([
//                    'counseling_id' => $counseling->id,
//                    'file_name' => $file->getClientOriginalName(),
//                    'path' => $filePath,
//                    'file_type' => $file->getClientMimeType(),
//                    'file_size' => $file->getSize(),
//                ]);
                CounselingAttachment::updateOrCreate(
                    ['counseling_id' => $cgoCounseling->id],
                    [
                        'file_name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]
                );
            }
//            if ($request->hasFile('attachment_details')) {
//                foreach ($request->file('attachment_details') as $attachment) {
//                    $fileType = $this->getFileType($attachment->getMimeType());
//                    $filePath = $attachment->store('images/counseling', 'public');
//                    $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
//                    $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
//
//                    CounselingAttachment::updateOrCreate(
//                        ['counseling_id' => $cgoCounseling->id],
//                        [
//                            'file_name' => $filename,
//                            'path' => $filePath,
//                            'file_type' => $fileType,
//                            'file_size' => $fileSize,
//                        ]
//                    );
//                }
//            }

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Counseling updated successfully',
                'data' => $cgoCounseling,
            ];
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get the file type based on the MIME type.
     *
     * @param string $mimeType
     * @return string
     */
    private function getFileType(string $mimeType): string
    {
        return match ($mimeType) {
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/pdf' => 'pdf',
            'image/png', 'image/jpg', 'image/jpeg' => 'image',
            default => 'Unknown',
        };
    }

}
