<?php

namespace App\Http\Controllers\Api\Cgo;

use App\Contracts\Services\CounselingServiceInterface;
use App\Enums\CgoCounselingStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\CgoCounseling;
use App\Models\Institute;
use App\Models\NvqCourses;
use App\Models\ReqCourse;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use App\Services\Cgo\NotificationManager;
use App\Services\Trainee\NotificationManager as NotificationforTrainee;
use App\Models\TraineeUser;
class CounselingController extends Controller
{
    private CounselingServiceInterface $counselingService;
    protected $notificationManager;
    protected $notificationforTrainee;
    public function __construct(CounselingServiceInterface $counselingService, NotificationManager $notificationManager, NotificationforTrainee $notificationforTrainee )
    {
        $this->counselingService = $counselingService;
        $this->notificationManager = $notificationManager;
        $this->notificationforTrainee= $notificationforTrainee;
    }
    public function confirmCounseling(Request $request)
    {
        try {
            $counseling = CgoCounseling::query()->find($request->id);
            if (!$counseling) {
                return response()->json(['status' => 'error', 'message' => 'Counseling not found'], 404);
            }
            // Only the CGO this counseling is currently assigned to may act on it.
            if (optional($counseling->cgoUser)->id !== auth('cgo')->id()) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to manage this counseling'], 403);
            }
            switch ($counseling->status) {
                case getCodeIdByStringEn('counselling_status', 'confirm'):
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Counseling already confirmed',
                    ], 400);
                case getCodeIdByStringEn('counselling_status', 'completed'):
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Counseling already canceled',
                    ], 400);
            }
            if ($counseling->status === getCodeIdByStringEn('counselling_status', 'request')) {
                if(!empty($counseling->trainee_id)){
                    $trainee= TraineeUser::find($counseling->trainee_id);
                    $this->notificationforTrainee->sendNotificationCgoConfirmCounselingToTrainee($trainee, $counseling);
                }
                if(!empty($request->date)){
                    $counseling->available_time=$request->date;
                }
                $counseling->status = getCodeIdByStringEn('counselling_status', 'confirm');
                $counseling->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Counseling confirmed successfully',
                ]);
            }
            throw new \Exception('Failed to confirm counseling');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function denyCounseling(Request $request)
    {
        try {
            $counseling = CgoCounseling::query()->find($request->counselingId);
            if (!$counseling) {
                return response()->json(['status' => 'error', 'message' => 'Counseling not found'], 404);
            }
            // Only the CGO this counseling is currently assigned to may act on it.
            if (optional($counseling->cgoUser)->id !== auth('cgo')->id()) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to manage this counseling'], 403);
            }
            switch ($counseling->status) {
                case getCodeIdByStringEn('counselling_status', 'confirm'):
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Counseling already confirmed',
                    ], 400);
                case getCodeIdByStringEn('counselling_status', 'completed'):
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Counseling already canceled',
                    ], 400);
            }
            if ($counseling->status === getCodeIdByStringEn('counselling_status', 'request')) {
                $counseling->status = getCodeIdByStringEn('counselling_status', 'cancel');
                $counseling->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Counseling canceled successfully',
                ]);
            }
            throw new \Exception('Failed to cancel counseling');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchInstitutes(Request $request)
    {
        $search = $request->input('search');

        $query = Institute::query();
        $query->whereRaw('LOWER(active_status) LIKE ?', ['active']); // Only get active institutes

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'ILIKE', '%' . $search . '%')
                    ->orWhere('reg_no', 'ILIKE', '%' . $search . '%');
            });
        }

        // Return all matching results without pagination
        $results = $query->get(['id', 'name', 'reg_no']);

        return response()->json([
            'results' => $results->map(function ($institute) {
                return [
                    'id' => $institute->id,
                    'text' => $institute->name . ' (' . $institute->reg_no . ')',
                ];
            }),
        ]);
    }
    public function searchNvqCourse(Request $request)
    {
        $search = $request->input('search');

        $query = NvqCourses::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('course_name', 'ILIKE', '%' . $search . '%')
                    ->orWhere('reg_no', 'ILIKE', '%' . $search . '%');
            });
        }

        // Return all matching results without pagination
        $results = $query->get(['id', 'course_name', 'reg_no']);

        return response()->json([
            'results' => $results->map(function ($nvq_course) {
                return [
                    'id' => $nvq_course->id,
                    'text' => $nvq_course->course_name . ' (' . $nvq_course->reg_no . ')',
                ];
            }),
        ]);
    }
    public function searchTvecCourse(Request $request)
    {
        $search = $request->input('search');

        $query = ReqCourse::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('course_name', 'ILIKE', '%' . $search . '%')
                    ->orWhere('institute_reg_no', 'ILIKE', '%' . $search . '%');
            });
        }

        // Return all matching results without pagination
        $results = $query->get(['id', 'course_name', 'institute_reg_no']);

        return response()->json([
            'results' => $results->map(function ($tvec_course) {
                return [
                    'id' => $tvec_course->id,
                    'text' => $tvec_course->course_name . ' (' . $tvec_course->institute_reg_no . ')',
                ];
            }),
        ]);
    }
}
