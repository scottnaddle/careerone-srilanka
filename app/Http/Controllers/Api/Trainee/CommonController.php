<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Enums\ApiResponseStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\District;
use App\Models\Institute;
use App\Models\NVQLevel;
use App\Models\Occupation;
use App\Models\Province;
use App\Models\Sector;
use App\Http\Controllers\Api\Trainee\BaseController as BaseController;
use App\Models\Banner;
use App\Models\CategorySystem;
use App\Models\Company;
use App\Models\EventType;
use App\Models\TraineeUser;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeJobService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommonController extends BaseController
{
    protected TraineeJobService $traineeJobService;
    protected ProvincesDistrictsService $provincesDistrictsService;

    public function __construct(TraineeJobService $traineeJobService, ProvincesDistrictsService $provincesDistrictsService)
    {
        // TODO: Middleware
        $this->traineeJobService = $traineeJobService;
        $this->provincesDistrictsService = $provincesDistrictsService;
    }
    public function getCommonData()
    {
        $institutes = Institute::get();
        $provinces = Province::get();
        $districts = District::get();
        $sectors = Sector::get();
        $nvqs = NVQLevel::get();
        $data = [
            'institutes' => $institutes,
            'provinces' => $provinces,
            'districts' => $districts,
            'sectors' => $sectors,
            'nvqs' => $nvqs,
        ];
        return $this->sendResponse($data, '');
    }
    public function deleteTraineeUser()
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->sendError('User not authenticated', [], 401);
        }
        $findUser = TraineeUser::find($user->id);
        if (!$findUser) {
            return $this->sendError('User not found', [], 404);
        }
        $findUser->delete();

        return $this->sendSuccess('User deleted successfully', [], 200);
    }

    public function getUserInformation(): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->sendError('User not authenticated', [], 401);
        }
        $trainingInformations = \App\Models\TraineeTrainingHistory::where('trainee_id', $user->id)->first();
        if ($trainingInformations) {
            $informations = json_decode($trainingInformations->content);
            $user->trainingInformations = $informations;
        }
        $user->total_job_applies = count($user->jobApplies);
        $user->total_counseling = count($user->cgoCounseling);
        $user->total_job_matches = count($user->jobMatches);
        unset($user->job_applies);
        $data['data'] = $user;
        $data['active_delete_button'] = env('ACTIVE_DELETE_BUTTON', false);
        return $this->sendResponse($data, 'Success');
    }


    public function getTraineeTrainingHistory() {
        $traineeUser = Auth::guard('sanctum')->user();
        $status = ApiResponseStatusEnums::OK;

        if (!$traineeUser) {
            return response()->json([
                'success' => true,
                'message' => 'Trainee not found!',
                'status' => $status->value
            ]);
        }

        // Initialize the service to fetch training information
        $traineeInformationService = new \App\Services\Trainee\TraineeInformationService();
        $trainingInformations = $traineeInformationService->getTrainingHistoryInformation($traineeUser->nic);
        $status = ApiResponseStatusEnums::OK;
        // If service request fails, try fetching data from local database
        if (isset($trainingInformations['error'])) {
            $trainingInformations = \App\Models\TraineeTrainingHistory::where('trainee_id', $traineeUser->id)->first();
            if (!$trainingInformations) {
                return response()->json([
                    'success' => true,
                    'message' => 'No training information found.',
                    'status' => $status->value
                ]);
            }

            $informations = json_decode($trainingInformations->content);
            return response()->json([
                'success' => true,
                'data' => [
                    'data' => $informations
                ],
                'message' => 'No training information found.',
                'status' => $status->value
            ]);
        }

        // If service request succeeds but no message data is available
        if (!isset($trainingInformations['message']) || empty($trainingInformations['message'])) {
            return response()->json([
                'success' => true,
                'message' => 'No training information available.',
                'status' => $status->value
            ]);
        }

        // Parse the response data
        $informations = $trainingInformations['message'];
        return response()->json([
            'success' => true,
            'data' => [
                'data' => $informations
            ],
            'message' => 'No training information found.',
            'status' => $status->value
        ]);
    }

    /**
     * API Get province
     * @return JsonResponse
     */
    public function getProvince(): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $provinceData = $this->provincesDistrictsService->getProvincesV2();
        return response()->json([
            'success' => true,
            'data' => $provinceData,
            'message' => '',
            'status' => $status->value
        ]);
    }

    public function getProvinces(Request $request)
    {
        $query = Province::query();

        if ($request->has('institute') && $request->institute == 1) {
            $query->with([
                'districts.divisionalSecretariats.institutes',
                'districts.institutes',
                'institutes'
            ]);
        } else {
            $query->with([
                'districts.divisionalSecretariats'
            ]);
        }

        $provinces = $query->get();

        return response()->json([
            'success' => true,
            'data' => $provinces,
            'message' => '',
            'status' => 'success',
        ]);
    }

    public function getInstitutes()
    {
        return response()->json([
            'success' => true,
            'data' => Institute::where('active_status', 'ILIKE', 'Active')->orderBy('name', 'asc')->get(),
            'message' => '',
            'status' => 'success'
        ]);
    }
    /**
     * API Get district by province id
     * @param Request $request
     * @return JsonResponse
     */
    public function getDistrict(Request $request): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $districtData = $this->provincesDistrictsService->getDistrictsByProvinceId($request['province_id']);
        return response()->json([
            'success' => true,
            'data' => $districtData,
            'message' => '',
            'status' => $status->value
        ]);
    }
    public function getInstituteByDistrict(Request $request): JsonResponse
    {
        try{
            $institute=Institute::where('dist_id',$request->dist_id)->get();
            return response()->json([
                'success' => true,
                'data' => $institute,
                'message' => '',
                'status' => 200
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e,
                'status' => 500
            ]);
        }
    }
    public function getInstitutesByDistrict($districtId)
    {
        $institutes = Institute::where('dist_id', $districtId)->orderBy('name', 'asc')->get();
        return response()->json($institutes);
    }

    public function getDistrictsByInstitute($instituteId)
    {
        $institute = Institute::find($instituteId);
        $districts = $institute ? District::where('id', $institute->district_id)->get() : [];
        return response()->json($districts);
    }

    /**
     * API Get divisional by district id
     * @param Request $request
     * @return JsonResponse
     */
    public function getDivisionalSecretariat(Request $request): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $divisionalSecretariatData = $this->provincesDistrictsService->getDivisionalSecretariatByDistrictId($request['district_id']);
        return response()->json([
            'success' => true,
            'data' => $divisionalSecretariatData,
            'message' => 'Get list divisional secretariat successfully!',
            'status' => $status->value
        ]);
    }

    /**
     * API Get Sector
     * @return JsonResponse
     */
    public function getSector(): JsonResponse
    {
        $status = ApiResponseStatusEnums::OK;
        $sectorData = $this->traineeJobService->getSector();
        return response()->json([
            'success' => true,
            'data' => $sectorData,
            'message' => '',
            'status' => $status->value
        ]);
    }

    public function getEventTypes(Request $request) {
        $language = $request->query('lang');
        $eventTypes = getCodeList('event_type', $language);
        $status = ApiResponseStatusEnums::OK;
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $eventTypes->count(),
                'data' => $eventTypes
            ],
            'message' => 'Get list event types successfully!',
            'status' => $status->value
        ]);
    }

    public function getCodeList(Request $request) {
        $language = $request->query('lang');
        $module = $request->query('module');
        $codeList = getCodeList($module, $language);
        $status = ApiResponseStatusEnums::OK;
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $codeList->count(),
                'data' => $codeList
            ],
            'message' => 'Get code list successfully!',
            'status' => $status->value
        ]);
    }

    public function getNoticeTypes(Request $request) {
        $language = $request->query('lang');
        $noticeTypes = getCodeList('notice_type', $language);
        $status = ApiResponseStatusEnums::OK;
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $noticeTypes->count(),
                'data' => $noticeTypes
            ],
            'message' => 'Get list notice types successfully!',
            'status' => $status->value
        ]);
    }

    public function getBanners() {
        $banners = Banner::where('is_visible', true)->with(['bannerImage'])->orderBy('sort', 'asc')->get();
        $status = ApiResponseStatusEnums::OK;
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $banners->count(),
                'data' => $banners
            ],
            'message' => 'Get list banners successfully!',
            'status' => $status->value
        ]);
    }

    public function getCompanyInformation(Request $request) {
        $language = $request->has('lang') ? $request->lang : null;
        $status = ApiResponseStatusEnums::OK;
        $companyInformations = getCodeList('company_information', $language);

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $companyInformations->count(),
                'data' => $companyInformations
            ],
            'message' => 'Get list company informations successfully!',
            'status' => $status->value
        ]);
    }

    public function getAboutus() {
        $countCGO = CgoUser::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)->count();
        $countTrainee = TraineeUser::where('active', true)->count();
//        $countInstitute = Institute::count();
        $countInstitute = CgoUser::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)->distinct('institute_id')->count('institute_id');
//        $countCompany = Company::where('active', true)->count();
        $countCompany = CompanyRecruiter::whereNotNull('verify_at')->whereNotNull('verify_by')->where('active', true)->count();
        $status = ApiResponseStatusEnums::OK;
        return response()->json([
            'success' => true,
            'data' => [
                'total' => 3,
                'data' => [
                    'countCGO' => $countCGO,
                    'countTrainee' => $countTrainee,
                    'countInstitute' => $countInstitute,
                    'countCompany'=>$countCompany
                ]
            ],
            'message' => 'Get number for About us successfully!',
            'status' => $status->value
        ]);
    }

}
