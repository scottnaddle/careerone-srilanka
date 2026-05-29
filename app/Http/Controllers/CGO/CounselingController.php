<?php

namespace App\Http\Controllers\CGO;

use App\Contracts\Services\CounselingServiceInterface;
use App\Enums\CgoCounselingStatusEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\CGO\RejectCounselingRequest;
use App\Http\Requests\CGO\StoreOfflineCounselingRequest;
use App\Http\Requests\CGO\StoreResultCounselingRequest;
use App\Models\CategorySystem;
use App\Models\CgoCounseling;
use App\Models\CgoCounselingAssignHistory;
use App\Models\CgoUser;
use App\Models\TraineeUser;
use App\Services\Cgo\NotificationManager;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\CounselingAttachment;
use App\Models\District;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CounselingController extends Controller
{
    private string $model;
    protected $notificationManager;
    protected $counselingService;

    public function __construct(CounselingServiceInterface $counselingService, NotificationManager $notificationManager)
    {
        $this->middleware('cgo.auth');
        $this->model = CgoCounseling::class;

        $this->counselingService = $counselingService;

        $this->currentFragment = request()->segment(2) ?? 'my-schedule';

        $this->notificationManager = $notificationManager;
        View::share([
            'isTabMySchedule' => $this->currentFragment === 'my-schedule',
            'isTabCounselingList' => $this->currentFragment === 'counseling-list',
        ]);
    }

    public function getCounselingList(Request $request)
    {
        $listCounseling =  $this->counselingService->getListsOfCounselingByCgoId($request, Auth::guard('cgo')->user()->id);


        return view('cgo.career-guidance.counseling.counseling-list',
            compact('listCounseling'));
    }

    public function show($id)
    {
        $counseling = $this->counselingService->getCounselingById($id);
        $CGOList = [];
        if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm')) {
            $CGOList = CgoUser::where('institute_id', Auth::guard('cgo')->user()->institute_id)->where('id', '!=', Auth::guard('cgo')->id())->get();
        }
        $objectCounselingList = $counseling->cgoCounselingAssignHistory;
        $assigneeToId = $objectCounselingList->isNotEmpty() ? $objectCounselingList->first()->assignee_to : null;
        $currentUserId = Auth::guard('cgo')->user()->id;
        $rejectCount = DB::table('user_actions')
        ->where('cgo_user_id', $currentUserId)
        ->where('action', 'Rejected counseling')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

        return view('cgo.career-guidance.counseling.counseling-detail', compact('counseling','assigneeToId','rejectCount', 'CGOList'));
    }

    public function createOfflineCounseling()
    {
        $language = app()->getLocale();
        $moduleColumn = match ($language) {
            'en' => 'code_name_en',
            'tm' => 'code_name_tm',
            'sn' => 'code_name_sn',
            default => 'code_name_en',
        };

        $listCounselingField = CategorySystem::where('module', 'counseling')
                                ->select('id', \DB::raw("$moduleColumn as name"))
                                ->get();
        // $listCounselingField = $this->counselingService->categoryModule();
        $districts = District::findOrFail(Auth::guard('cgo')->user()->district_id);
        $instituteName = CgoUser::query()->where('id', Auth::guard('cgo')->user()->id)->with('institute')->firstOrFail()->institute->name;

        return view('cgo.career-guidance.counseling.create-offline',
            compact('listCounselingField', 'instituteName','districts'));
    }

    public function storeOfflineCounseling(StoreOfflineCounselingRequest $request): RedirectResponse
    {
        $counselling = $this->counselingService->storeOfflineCounseling($request);

        return redirect()->route('cgo.career-guidance.counseling.counseling-list.show', ['id' => $counselling->id])->with('success','Create new counseling successfully');
    }

    public function storeResultCounseling(StoreResultCounselingRequest $request, $id): RedirectResponse
    {
        $this->counselingService->storeResultCounseling($request, $id);
        if ($request->temporaty_save_flag == 'false') {
            $this->counselingService->updateCounselingStatus($id, getCodeIdByStringEn('counselling_status', 'completed'));
        }

        return redirect()->route('cgo.career-guidance.counseling.counseling-list.show', $id);
    }
    public function rejectCounseling(RejectCounselingRequest $request, $id)
    {
        try {
            $counselingRecord = DB::table('cgo_counseling_assign_histories')
                ->where('counseling_id', $id)
                ->first();
            $currentUserId = Auth::guard('cgo')->user()->id;
            if ($counselingRecord->assignee_to !== $currentUserId) {
                return redirect()
                    ->route('cgo.career-guidance.counseling.counseling-list')
                    ->with('error', __('cgo.error_toastify') . " (You are not authorized to reject this counseling)");
            }
            $result_err = $this->counselingService->rejectCounseling($request, $id);
            DB::table('user_actions')->insert([
                'cgo_user_id' => $currentUserId,
                'action' => 'Rejected counseling',
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);

            return redirect()
                ->route('cgo.career-guidance.counseling.counseling-list')
                ->with( $result_err['status'], $result_err['message']);

        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return redirect()
                ->route('cgo.career-guidance.counseling.counseling-list')
                ->with('error', __('cgo.error_toastify') . " (Code: $errorCode)")
                ->with('error_message', $errorMessage);
        }
    }



    public function getMySchedule(Request $request)
    {
        $getQuery = $request->query('date');
        $currentDate = now();
        if ($getQuery) {
            $dateObject = \DateTime::createFromFormat('Y-m-d', $getQuery);

            if ($dateObject !== false) {
                $currentDate = $dateObject->format('Y-m-d');
            } else {
                $currentDate = now()->toDateString();
            }
        }
        $listScheduleCounseling = $this->counselingService->getListsOfScheduleCounselingByCgoId( Auth::guard('cgo')->user()->id ,$currentDate);

        $listWorkingDayCurrentWeek = $this->counselingService->getListsOfWorkingDayOfWeek($currentDate);
        return view('cgo.career-guidance.counseling.my-schedule', compact('listScheduleCounseling',
            'listWorkingDayCurrentWeek', 'currentDate'));
    }
    public function getCareerTest() {
        return view('cgo.career-guidance.counseling.career-test');
    }
    public function getCounselingHistory(Request $request){
        $id_user=  Auth::guard(activeGuard())->user()->id;
        if($id_user){
             $listCounselingHistory = CgoCounseling::query()
            ->orderBy('cgo_counselings.available_time', 'desc')
            ->where('cgo_counselings.trainee_id',$id_user)
            ->paginate(10)
            ->appends($request->query());
        return view('cgo.career-guidance.counseling.counseling-history', compact('listCounselingHistory'));
        }else{
            return redirect()->back();
        }

    }
    public function downloadAttachment($attachmentId)
    {
        $attachment = CounselingAttachment::find($attachmentId);
        if (!$attachment) {
            return response()->json(['error' => 'Attachment not found'], 404);
        }

        $filePath = $attachment->path;
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        return Storage::disk('public')->download($filePath, $attachment->file_name);
    }

    public function changeCGO(Request $request) {
        $counseling = CgoCounseling::where('id', $request->counseling_id)->first();
        if ($counseling) {
            $counseling->status = 1;
            $counseling->save();
            //Update assign
            $assignHistory = CgoCounselingAssignHistory::where('counseling_id', $counseling->id)->first();
            if ($assignHistory) {
                $from = !empty($assignHistory->assignee_from)
                    ? (is_array($assignHistory->assignee_from) ? $assignHistory->assignee_from : [$assignHistory->assignee_from])
                    : [];
                array_push($from, $assignHistory->assignee_to);
                $assignHistory->assignee_from = $from;
                $assignHistory->assignee_to = $request->cgo_id;
                $assignHistory->save();
                $newCgo = CgoUser::where('id', $request->cgo_id)->first();
                if ($newCgo) {
                    $this->notificationManager->sendAllocatingAounselingNotificationtoCgo($newCgo, $counseling);
                }

            }
            return redirect(route('cgo.career-guidance.counseling.counseling-list'));
        }
    }

    public function  getTraineeInfo($nic)
    {
        $trainee = TraineeUser::where('nic', 'ILIKE', $nic)->first();

        if ($trainee) {
            $fullName = $trainee->full_name;

            if (str_contains($fullName, '.')) {
                $parts = explode('.', $fullName);
                $lastName = array_pop($parts);
                $firstName = implode('.', $parts) . '.';
            } else {
                $parts = explode(' ', $fullName);
                $lastName = array_pop($parts);
                $firstName = implode(' ', $parts);
            }
            return response()->json([
                'success' => true,
                'mobile' => $trainee->mobile ?? '',
                'email' => $trainee->email ?? '',
                'first_name' => $firstName ?? '',
                'last_name' => $lastName ?? '',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Can not find trainee information.'
        ]);
    }

}
