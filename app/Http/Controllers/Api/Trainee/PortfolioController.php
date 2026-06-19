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
        $portfolio = Portfolio::where('trainee_id', Auth::guard('sanctum')?->id())->latest()->first();
        if($portfolio) {
            $data['existed'] = true;
            $portfolioData = $portfolio->data;
            $portfolio->data = $this->normalizePortfolioData($portfolioData);
            $data['data'] = $portfolio;
            return $this->sendResponse($data, 'Success');
        }else {
            $current_user = Auth::guard('sanctum')->user();
            if (!$current_user) {
                abort(403, 'Unauthorized access');
            }

            // 1. Get trainee information
            $traineeInformations = $current_user;
            $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $current_user->id)->first();

            // Initialize the default value arrays
            $tvecEducations = [];
            $nvqEducations = [];

            // Handle TVEC educations
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

            // Handle NVQ educations
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

            $portfolioData = $this->normalizePortfolioData($portfolioData);
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
            'technical_skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'evidences' => 'nullable|array',
            'avatar' => 'nullable',
            'cover_photo' => 'nullable',
            'has_work_experience' => 'nullable',
            'goal_type' => 'nullable|string',
            'short_term_goals' => 'nullable|string',
            'long_term_goals' => 'nullable|string',
            'career_interests' => 'nullable|array',
            'references' => 'nullable|array',
        ]);
        $portfolio = Portfolio::updateOrCreate(
            ['trainee_id' => Auth::guard('sanctum')->id() ?? auth()->guard('sanctum')->id()],
            ['data' => $validated]
        );

        return response()->json($portfolio, 201);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->trainee_id !== auth('sanctum')->id()) {
            abort(403);
        }

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
            'technical_skills' => 'sometimes|array',
            'languages' => 'sometimes|array',
            'evidences' => 'sometimes|array',
            'avatar' => 'nullable',
            'cover_photo' => 'nullable',
            'has_work_experience' => 'nullable',
            'goal_type' => 'nullable|string',
            'short_term_goals' => 'nullable|string',
            'long_term_goals' => 'nullable|string',
            'career_interests' => 'nullable|array',
            'references' => 'nullable|array',
        ]);

        $portfolio->update([
            'data' => array_merge($portfolio->data, $validated)
        ]);

        return response()->json($portfolio);
    }

    public function deletePortfolio(Request $request) {
        $portfolio = Portfolio::where('id', $request->id)->where('trainee_id', auth('sanctum')->id())->first();
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
        // Check whether the portfolio already exists
        if ($portfolio = Portfolio::where('trainee_id', Auth::guard('sanctum')->id())->latest()->first()) {
            $data['existed'] = true;
            $portfolioData = $portfolio->data;
            $portfolio->data = $this->normalizePortfolioData($portfolioData);
            $data['data'] = $portfolio;
            return $this->sendResponse($data, 'Success');
        }

        $current_user = Auth::guard('sanctum')->user();
        if (!$current_user) {
            abort(403, 'Unauthorized access');
        }

        // 1. Get trainee information
        $traineeInformations = $current_user;
        $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $current_user->id)->first();

        // Initialize the default value arrays
        $tvecEducations = [];
        $nvqEducations = [];

        // Handle TVEC educations
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

        // Handle NVQ educations
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

        $portfolioData = $this->normalizePortfolioData($portfolioData);

        $data['existed'] = false;
        $data['data'] = $portfolioData;
        return $this->sendResponse($data, 'Success');
    }
    public function edit()
    {
        // Check whether the portfolio already exists
        if ($portfolio = Portfolio::where('trainee_id', Auth::guard('sanctum')->id())->latest()->first()) {
            $portfolioData = $portfolio->data;
            $portfolio->data = $this->normalizePortfolioData($portfolioData);
            $data['data'] = $portfolio;
            return $this->sendResponse($data, 'Success');
        }
        return $this->sendError('Portfolio not found', [], 404);
    }

    private function normalizePortfolioData($portfolioData)
    {
        if (!is_array($portfolioData)) {
            $portfolioData = [];
        }

        // Migrate old format 'skills' to 'technical_skills'
        if (!isset($portfolioData['technical_skills']) && isset($portfolioData['skills'])) {
            $portfolioData['technical_skills'] = $portfolioData['skills'];
        }

        // Default structures for new wizard fields
        $portfolioData['technical_skills'] = $portfolioData['technical_skills'] ?? [];
        $portfolioData['skills'] = $portfolioData['skills'] ?? ($portfolioData['technical_skills'] ?? []);
        $portfolioData['has_work_experience'] = $portfolioData['has_work_experience'] ?? null;
        $portfolioData['goal_type'] = $portfolioData['goal_type'] ?? '';
        $portfolioData['short_term_goals'] = $portfolioData['short_term_goals'] ?? '';
        $portfolioData['long_term_goals'] = $portfolioData['long_term_goals'] ?? '';
        
        $portfolioData['career_interests'] = $portfolioData['career_interests'] ?? [
            'work_type' => '',
            'work_mode' => '',
            'career_fields' => []
        ];
        // Ensure career_interests sub-keys
        if (is_array($portfolioData['career_interests'])) {
            $portfolioData['career_interests']['work_type'] = $portfolioData['career_interests']['work_type'] ?? '';
            $portfolioData['career_interests']['work_mode'] = $portfolioData['career_interests']['work_mode'] ?? '';
            $portfolioData['career_interests']['career_fields'] = $portfolioData['career_interests']['career_fields'] ?? [];
        }

        $portfolioData['ojt_experiences'] = $portfolioData['ojt_experiences'] ?? [];
        $portfolioData['experiences'] = $portfolioData['experiences'] ?? [];
        $portfolioData['educations'] = $portfolioData['educations'] ?? [];
        $portfolioData['languages'] = $portfolioData['languages'] ?? [];
        $portfolioData['evidences'] = $portfolioData['evidences'] ?? [];
        $portfolioData['references'] = $portfolioData['references'] ?? [];

        return $portfolioData;
    }
}
