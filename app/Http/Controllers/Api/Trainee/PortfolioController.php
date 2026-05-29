<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\TraineeTrainingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends BaseController
{
    public function show()
    {
        $portfolio = Portfolio::where('trainee_id', Auth::guard('sanctum')?->id())->first();
        if($portfolio) {
            $data['existed'] = true;
            $data['data'] = $portfolio;
            return $this->sendResponse($data, 'Success');
        }else {
            $current_user = Auth::guard('sanctum')->user();
            if (!$current_user) {
                abort(403, 'Unauthorized access');
            }

            // 1. Lấy thông tin trainee
            $traineeInformations = $current_user;
            $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $current_user->id)->first();

            // Khởi tạo mảng giá trị mặc định
            $tvecEducations = [];
            $nvqEducations = [];

            // Xử lý TVEC educations
            if ($traineeTrainingInformations && !empty($traineeTrainingInformations->content)) {
                try {
                    $trainingContent = json_decode($traineeTrainingInformations->content);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($trainingContent)) {
                        foreach ($trainingContent as $trainingInformation) {
                            if (isset($trainingInformation->INSTITUTE, $trainingInformation->COURSE)) {
                                $tvecEducations[] = [
                                    'institute' => $trainingInformation->INSTITUTE->INSTITUTE_NAME ?? 'N/A',
                                    'industry_sector' => $trainingInformation->COURSE->INDUSTRY_SECTOR ?? 'N/A',
                                    'course_name' => $trainingInformation->COURSE->COURSE_NAME ?? 'N/A',
                                    'from' => $trainingInformation->COURSE->START_DATE ?? null,
                                    'to' => $trainingInformation->COURSE->END_DATE ?? null,
                                ];
                            }
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error('Error parsing TVEC educations: ' . $e->getMessage());
                }
            }

            // Xử lý NVQ educations
            if ($traineeTrainingInformations && !empty($traineeTrainingInformations->nvq_content)) {
                try {
                    $nvqContent = json_decode($traineeTrainingInformations->nvq_content);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($nvqContent)) {
                        foreach ($nvqContent as $nvqInformation) {
                            $nvqEducations[] = [
                                'qualification_name' => $nvqInformation->QUALIFICATION_NAME ?? 'N/A',
                                'effective_date' => $nvqInformation->EFFECTIVE_DATE ?? null,
                                'level' => $nvqInformation->QUALIFICATION_LEVEL ?? 'N/A',
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error('Error parsing NVQ educations: ' . $e->getMessage());
                }
            }

            // Default empty portfolio structure
            $portfolioData = [
                'fullname' => $traineeInformations->fullName ?? '',
                'avatar' => $traineeInformations->profile_image ?? '',
                'cover_photo' => '',
                'description' => '',
                'summary' => $traineeInformations ? getNewestTrainingInformationOfTrainee($traineeInformations->id) : '',
                'basic_information' => [
                    'fullname' => $traineeInformations->fullName ?? '',
                    'email' => $traineeInformations->email ?? '',
                    'phone' => $traineeInformations->mobile ?? '',
                    'address' => $traineeInformations->contact_address ?? ''
                ],
                'about_me' => '',
                'tvec_educations' => $tvecEducations,
                'nvq_educations' => $nvqEducations,
                'educations' => [],
                'ojt_experiences' => [],
                'experiences' => [],
                'skills' => [
                ],
                'languages' => [],
                'evidences' => []
            ];
        }
        $data['existed'] = false;
        $data['data'] = $portfolioData;
        return $this->sendResponse($data, 'Success');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'description' => 'max:255',
//            'summary' => 'required|string|max:255',
            'basic_information' => 'required|array',
            'about_me' => '',
            'tvec_educations' => 'nullable|array',
            'nvq_educations' => 'nullable|array',
            'educations' => 'nullable|array',
            'ojt_experiences' => 'nullable|array',
            'experiences' => 'nullable|array',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'evidences' => 'nullable|array',
            'avatar' => 'nullable',
            'cover_photo' => 'nullable',
        ]);
        if ($portfolio = Portfolio::where('trainee_id', auth()->guard('sanctum')->id())->first()) {
            $portfolio->data = $validated;
            $portfolio->save();
        }else {
            $portfolio = Portfolio::create([
                'trainee_id' => Auth::guard('sanctum')->id(),
                'data' => $validated
            ]);
        }

        return response()->json($portfolio, 201);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'fullname' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'summary' => 'sometimes|string|max:255',
            'basic_information' => 'sometimes|array',
            'about_me' => 'sometimes|string',
            'tvec_educations' => 'sometimes|array',
            'nvq_educations' => 'sometimes|array',
            'educations' => 'sometimes|array',
            'ojt_experiences' => 'sometimes|array',
            'experiences' => 'sometimes|array',
            'skills' => 'sometimes|array',
            'languages' => 'sometimes|array',
            'evidences' => 'sometimes|array',
            'avatar' => 'nullable',
            'cover_photo' => 'nullable',
        ]);

        $portfolio->update([
            'data' => array_merge($portfolio->data, $validated)
        ]);

        return response()->json($portfolio);
    }

    public function deletePortfolio(Request $request) {
        $portfolio = Portfolio::where('id', $request->id)->first();
        if($portfolio) {
            $portfolio->delete();
            $data = [];
            return $this->sendResponse($data, 'Portfolio deleted successfully');
        }else {
            return $this->sendError([], 'Portfolio not found');
        }

    }
    public function create()
    {
        // Kiểm tra portfolio đã tồn tại
        if ($portfolio = Portfolio::where('trainee_id', Auth::guard('sanctum')->id())->first()) {
            $data['existed'] = true;
            $data['data'] = $portfolio;
            return $this->sendResponse($data, 'Success');
        }

        $current_user = Auth::guard('sanctum')->user();
        if (!$current_user) {
            abort(403, 'Unauthorized access');
        }

        // 1. Lấy thông tin trainee
        $traineeInformations = $current_user;
        $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $current_user->id)->first();

        // Khởi tạo mảng giá trị mặc định
        $tvecEducations = [];
        $nvqEducations = [];

        // Xử lý TVEC educations
        if ($traineeTrainingInformations && !empty($traineeTrainingInformations->content)) {
            try {
                $trainingContent = json_decode($traineeTrainingInformations->content);
                if (json_last_error() === JSON_ERROR_NONE && is_array($trainingContent)) {
                    foreach ($trainingContent as $trainingInformation) {
                        if (isset($trainingInformation->INSTITUTE, $trainingInformation->COURSE)) {
                            $tvecEducations[] = [
                                'institute' => $trainingInformation->INSTITUTE->INSTITUTE_NAME ?? 'N/A',
                                'industry_sector' => $trainingInformation->COURSE->INDUSTRY_SECTOR ?? 'N/A',
                                'course_name' => $trainingInformation->COURSE->COURSE_NAME ?? 'N/A',
                                'from' => $trainingInformation->COURSE->START_DATE ?? null,
                                'to' => $trainingInformation->COURSE->END_DATE ?? null,
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {
                logger()->error('Error parsing TVEC educations: ' . $e->getMessage());
            }
        }

        // Xử lý NVQ educations
        if ($traineeTrainingInformations && !empty($traineeTrainingInformations->nvq_content)) {
            try {
                $nvqContent = json_decode($traineeTrainingInformations->nvq_content);
                if (json_last_error() === JSON_ERROR_NONE && is_array($nvqContent)) {
                    foreach ($nvqContent as $nvqInformation) {
                        $nvqEducations[] = [
                            'qualification_name' => $nvqInformation->QUALIFICATION_NAME ?? 'N/A',
                            'effective_date' => $nvqInformation->EFFECTIVE_DATE ?? null,
                            'level' => $nvqInformation->QUALIFICATION_LEVEL ?? 'N/A',
                        ];
                    }
                }
            } catch (\Exception $e) {
                logger()->error('Error parsing NVQ educations: ' . $e->getMessage());
            }
        }

        // Default empty portfolio structure
        $portfolioData = [
            'fullname' => $traineeInformations->fullName ?? '',
            'avatar' => $traineeInformations->profile_image ?? null,
            'cover_photo' => '',
            'description' => '',
            'summary' => $traineeInformations ? getNewestTrainingInformationOfTrainee($traineeInformations->id) : '',
            'basic_information' => [
                'fullname' => $traineeInformations->fullName ?? '',
                'email' => $traineeInformations->email ?? '',
                'phone' => $traineeInformations->mobile ?? '',
                'address' => $traineeInformations->contact_address ?? ''
            ],
            'about_me' => '',
            'tvec_educations' => $tvecEducations,
            'nvq_educations' => $nvqEducations,
            'educations' => [],
            'ojt_experiences' => [],
            'experiences' => [],
            'skills' => [
            ],
            'languages' => [],
            'evidences' => []
        ];

        $data['existed'] = false;
        $data['data'] = $portfolioData;
        return $this->sendResponse($data, 'Success');
    }
    public function edit()
    {
        // Kiểm tra portfolio đã tồn tại
        if ($portfolio = Portfolio::where('trainee_id', Auth::guard('sanctum')->id())->first()) {

            $data['data'] = $portfolio;
            return $this->sendResponse($data, 'Success');
        }
    }
}
