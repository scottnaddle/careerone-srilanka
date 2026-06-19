<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Http\Controllers\Controller;
use App\Services\Trainee\TraineeCounselingService;
use App\Http\Requests\Trainee\StoreTraineeCounseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CgoCounseling;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class TraineeCounselingController extends BaseController
{
    protected $traineeCounselingService;
    public function __construct(TraineeCounselingService $traineeCounselingService)
    {
        $this->traineeCounselingService = $traineeCounselingService;
    }
    public function indexJson(Request $request)
    {
        $listCounselingHistory = $this->traineeCounselingService->getCounselingHistory($request);

        if ($listCounselingHistory) {
            return $this->sendResponse($listCounselingHistory, '');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'User not authenticated or no counseling history found.']);
        }
    }
    public function storeJson(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'available_date' => 'required|date|after_or_equal:today',
            'detail_information' => 'required|string|max:1000',
            'trainee_attachment' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:51200',
        ]);
        if ($validator->fails()) {
            $errorMessages = implode(", ", $validator->errors()->all());
            return $this->sendError('Validation failed.', ['error' => $errorMessages]);
        }

        $traineeUser = auth('sanctum')->check() ? auth('sanctum')->user() : null;

        $query = CgoCounseling::query()
            ->where('status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
            ->whereDate('available_time', $request->available_date)
            ->where('trainee_id', $traineeUser->id);
        if ($request->has('am_pm')) {
            $query->whereRaw('LOWER(shift) = ?', [strtolower($request->am_pm)]);
        }
        if ($query->exists()) {
            return $this->sendError('Validation failed.', ['error' => 'You can not request for guidance same time with other guidance created before!']);
        }

        $response = $this->traineeCounselingService->handleStore($request);

        if ($response['status'] == 'success') {
            return $this->sendResponse($response['message'], 'Counseling session created successfully!');
        } else if($response['status'] == 'cancel'){
            return $this->sendResponse($response['message'], $response['message']);
        }else {
            return $this->sendError('Error.', ['error' => $response['message']]);
        }
    }
    public function traineeCounselingRequestJson(Request $request)
    {
        $data = $this->traineeCounselingService->getCounselingRequestData();
        return $this->sendResponse($data, '');
    }
    public function showJson(string $id)
    {
        $counseling = $this->traineeCounselingService->getCounselingDetails($id);

        if ($counseling && $counseling->trainee_id == Auth::guard(activeGuard())->user()->id) {
            return $this->sendResponse($counseling, '');
        } else {
            return $this->sendError('Error.', ['error' => 'You do not have permission to access this counseling session.']);
        }
    }
    public function storeFeedbackJson(CgoCounseling $cgoCounseling, Request $request)
    {
        try {
            $this->traineeCounselingService->storeFeedbackData($cgoCounseling, $request);
            return $this->sendResponse('', 'Feedback successfully submitted.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving feedback.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function postEditJson(Request $request, CgoCounseling $cgoCounseling)
    {
        try{
              $response = $this->traineeCounselingService->handleEdit($request,$cgoCounseling);
              return $this->sendResponse('',$response['message']);
        }catch(NotFoundHttpException $e){
            \Log::error('Error in edit counselling: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving feedback.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
