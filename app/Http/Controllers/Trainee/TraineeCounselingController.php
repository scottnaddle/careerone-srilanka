<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CgoCounseling;
use Illuminate\Support\Facades\Auth;
use App\Models\CounselingField;
use Carbon\Carbon;
use App\Models\Institute;
use App\Models\District;
use App\Http\Requests\Trainee\StoreTraineeCounseling;
use App\Enums\CgoCounselingTypeEnums;
use App\Enums\CgoCounselingStatusEnums;
use App\Models\CgoUser;
use App\Models\CounselingAttachment;
use App\Models\CgoCounselingAssignHistory;
use App\Contracts\Services\CounselingServiceInterface;
use App\Services\Trainee\TraineeCounselingService;
use Illuminate\Support\Facades\DB;
use App\Services\Cgo\NotificationManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TraineeCounselingController extends Controller
{

    protected $counselingService;
    protected $notificationManager;
    protected $traineeCounselingService;
    public function __construct(CounselingServiceInterface $counselingService, NotificationManager $notificationManager, TraineeCounselingService $traineeCounselingService)
    {
        $this->middleware('trainee.auth')->except('downloadAttachment');
        $this->counselingService = $counselingService;
        $this->notificationManager = $notificationManager;
        $this->traineeCounselingService = $traineeCounselingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->traineeCounselingService->getCounselingHistory($request);
        if ($data) {
            $listCounselingHistory = $data['data'];
            return view('trainee.trainee-couseling.counseling-history', compact('listCounselingHistory'));
        } else {
            return redirect()->back();
        }
    }
    public function traineeCounselingRequest(Request $request)
    {
        $data = $this->traineeCounselingService->getCounselingRequestData();

        return view('trainee.trainee-couseling.counseling-request', $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'available_date' => 'required|date|after_or_equal:today',
            'detail_information' => 'required|string|max:1000',
            'trainee_attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $traineeUser = auth('trainee')->check() ? auth('trainee')->user() : null;
        $query = CgoCounseling::query()
            ->where('status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
            ->whereDate('available_time', $request->available_date)
            ->where('trainee_nic', $traineeUser->nic);
        if ($request->has('am_pm')) {
            $query->whereRaw('LOWER(shift) = ?', [strtolower($request->am_pm)]);
        }
        if ($query->exists()) {
            throw ValidationException::withMessages([
                'trainee_nic' => __('You can not request for guidance same time with other guidance created before!'),
            ]);
        }
        $response = $this->traineeCounselingService->handleStore($request);
        if ($response['status'] == 'success') {
            return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('success', 'Counseling session created successfully!');
        } else {
            return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('error', $response['message']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $counseling = $this->traineeCounselingService->getCounselingDetails($id);

        if ($counseling && $counseling->trainee_id == Auth::guard(activeGuard())->user()->id) {
            return view('trainee.trainee-couseling.counseling-detail', compact('counseling'));
        } else {
            return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('error', 'You do not have permission to access this page.');
        }
    }

    public function storeFeedback(CgoCounseling $cgoCounseling, Request $request)
    {
        $this->traineeCounselingService->storeFeedbackData($cgoCounseling, $request);

        return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('success', 'Feedback Success');
    }
    public function getMissingFeedback()
    {
        $fullFeedbackAttributes = ["organized", "friendly", "detailed", "kind", "good_service"];

        return $fullFeedbackAttributes;
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
    public function getEditCounseling(string $id)
    {
        $counseling = $this->traineeCounselingService->getCounselingDetails($id);
        $data = $this->traineeCounselingService->getCounselingRequestData();
        if ($counseling && $counseling->trainee_id == Auth::guard(activeGuard())->user()->id) {
            return view('trainee.trainee-couseling.counseling-edit', compact('counseling', 'data'));
        } else {
            return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('error', 'You do not have permission to access this page.');
        }
    }
    public function postEdit(StoreTraineeCounseling $request, CgoCounseling $cgoCounseling)
    {
        $response = $this->traineeCounselingService->handleEdit($request,$cgoCounseling);
        if ($response['status'] == 'success') {
            return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('success', $response['message']);
        } else {
            return redirect()->route('trainee.career-guidance.counseling.counseling-history')->with('error', $response['message']);
        }
    }


    public function getInstituteByDistrictId($districtId) {
        $institutes = Institute::where('active_status', 'ILIKE', 'Active')->where('dist_id', $districtId)->orderBy('name', 'asc')->get();
        return response()->json($institutes);
    }

}
