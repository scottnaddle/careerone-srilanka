<?php

namespace App\Http\Controllers\Trainee;

use App\Models\CareerTestTraineeResult;
use App\Models\Portfolio;
use App\Models\Resume;
use App\Models\TraineeTrainingHistory;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeInformationService;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use Illuminate\Support\Facades\File;
use App\Jobs\CreatePortfoliosJob;
class PortfolioController extends Controller
{
    public function __construct(TraineeInformationService $traineeInformationService, TraineeTrainingSyncService $traineeSyncService) {
        $this->middleware('trainee.auth')->except('previewResume', 'previewPortfolio', 'show', 'exportPortfolio');
        $this->traineeInformationService = $traineeInformationService;
        $this->traineeSyncService = $traineeSyncService;
    }

    public function getMyPortfolios() {
        $user = Auth::guard('trainee')->user();
        $portfolios = Portfolio::where('trainee_id', Auth::guard('trainee')->user()->id)->paginate(10);
        return view('trainee.career-guidance.portfolio.portfolio-list', compact('portfolios', 'user'));
    }

    public function getMyResumes() {
        $resumes = Resume::where('trainee_id', Auth::guard('trainee')->user()->id)->paginate(10);
        return view('trainee.career-guidance.portfolio.resume-list', compact('resumes'));
    }
    public function create()
    {
        // Check whether the portfolio already exists
        if (Portfolio::where('trainee_id', Auth::guard('trainee')->id())->exists()) {
            return redirect()->route('trainee.career-guidance.portfolios.show');
        }

        $current_user = Auth::guard('trainee')->user();
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
                'address' => $traineeInformations->contact_address ?? '',
                'gender' => $traineeInformations->gender ? (string) $traineeInformations->gender : '',
                'district' => $traineeInformations->district->name ?? ''
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

        $districts = \App\Models\District::all(['id', 'name']);
        $genders = getCodeList('gender');

        return view('portfolio.create', compact('portfolioData', 'districts', 'genders'));
    }
    public function edit()
    {
        // Check whether the portfolio already exists
        if ($portfolio = Portfolio::where('trainee_id', Auth::guard('trainee')->id())->latest()->first()) {

            $portfolioData = $portfolio->data;
            if (is_string($portfolioData)) {
                $portfolioData = json_decode($portfolioData, true);
            }
            if (!is_array($portfolioData)) {
                $portfolioData = [];
            }

            // === Migrate old format to new wizard format ===
            // Old format used 'skills', new wizard uses 'technical_skills'
            if (!isset($portfolioData['technical_skills']) && isset($portfolioData['skills'])) {
                $portfolioData['technical_skills'] = $portfolioData['skills'];
            }

            // Ensure new required fields have defaults if missing
            $portfolioData['technical_skills'] = $portfolioData['technical_skills'] ?? [];
            $portfolioData['has_work_experience'] = $portfolioData['has_work_experience'] ?? null;
            $portfolioData['goal_type'] = $portfolioData['goal_type'] ?? '';
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
            // === End migration ===

            $districts = \App\Models\District::all(['id', 'name']);
            $genders = getCodeList('gender');

            return view('portfolio.create', compact('portfolioData', 'districts', 'genders'));
        }
        return redirect()->route('trainee.career-guidance.portfolios.show');



    }

    public function savePortfolio(Request $request)
    {


        // Decode JSON properly
        $jsonData = json_decode($request->input('json_data'), true);

        if (!is_array($jsonData)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid JSON data'], 400);
        }

        $trainee_id = Auth::guard('trainee')->user()->id;
        $portfolio = Portfolio::where('trainee_id', $trainee_id)->latest()->first();
        if (!$portfolio) {
            $portfolio = new Portfolio();
        }

        // Ensure each key exists before assigning
        $portfolio->data = $jsonData['data'] ?? []; // Store as array (Laravel casts to JSON automatically)
        $portfolio->html = $jsonData['html'] ?? '';
        $portfolio->css = $jsonData['css'] ?? '';
        $portfolio->trainee_id = Auth::guard('trainee')->user()->id;
        $portfolio->save();

        return response()->json(['status' => 'success']);
    }


    public function loadPortfolio($id)
    {
        $template = Portfolio::where('id', $id)->first(); // Assuming you're loading the first template, adjust as needed

        if ($template) {
            return response()->json([
                'data' => $template->data    // CSS content stored in the DB
            ]);
        }
    }
    public function getStyleForExportPdf() {
        $cssPath = public_path('build/assets/app.css');
        if (File::exists($cssPath)) {
            // Get the CSS content
            $cssContent = File::get($cssPath);
            return response($cssContent, 200)
                ->header('Content-Type', 'text/css');
        }
        return null;
    }
    public function deletePortfolio(Request $request) {
        Portfolio::where('id', $request->pid)->delete();
        return redirect()->route('trainee.career-guidance.portfolio.get-portfolio');
    }
    public function deleteResume(Request $request) {
        $result = Resume::where('trainee_id', Auth::guard('trainee')->user()->id)->where('id', $request->id)->first();
        if ($result) {
            if (is_file($result->attachment)) {
                unlink($result->attachment);
            }
            $result->delete();
            return redirect()->route('trainee.career-guidance.portfolio.get-resume')->with('success', trans('system.information.content_management.deleted'));
        }else {
            return redirect()->route('trainee.career-guidance.portfolio.get-resume')->withErrors(trans('system.information.content_management.not_found'));
        }
    }

    public function exportPortfolio(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'pid' => 'required|integer|exists:portfolios,id',
        ]);

        $id = $request->pid;
        $portfolio = Portfolio::find($id);

        if ($portfolio) {
            $externalServerUrl = env('EXTERNAL_SERVER_URL') . '/generate-pdf';

            $trainee = $portfolio->trainee ?? (Auth::guard('trainee')->user());
            $fullName = $trainee ? $trainee->fullName : 'candidate';
            $fullNameSlug = \Str::slug($fullName, '-', 'ta');
            $fileName = $fullNameSlug . '-portfolio.pdf';

            try {
                $response = \Http::withoutVerifying() // Use only if SSL verification issues arise
                ->post($externalServerUrl, [
                    'url' => route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $portfolio->id, 'lang'=> app()->getLocale() ?? 'en']),
                    'file_name' => $fileName,
                ]);

                if ($response->successful()) {
                    return response($response->body(), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    ]);
                }

                return response()->json([
                    'error' => 'Failed to generate PDF on the external server',
                    'details' => $response->json(),
                ], $response->status());
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while contacting the external server',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json(['error' => 'Portfolio not found'], 404);
    }
    public function editPorfolio(Request $request) {
        $id = $request->pid;
        return view('trainee.career-guidance.portfolio.edit-portfolio', compact('id'));
    }

    public function previewPortfolio(Request $request) {

        $id = $request->pid;
        $portfolio = Portfolio::where('id', $id)->first();
        if ($portfolio) {
            $portfolioDatas = $portfolio->data;
            if (is_string($portfolioDatas)) {
                $portfolioDatas = json_decode($portfolioDatas, true);
            }
            return view('portfolio.preview', compact('portfolioDatas', 'portfolio'));

        }else{
            return back()->withErrors("Can not find the portfolio.");
        }
    }

    public function getMyInformation() {
        $current_user = TraineeUser::where('id', Auth::guard('trainee')->user()->id)->first();
        if ($current_user) {
            //1. Get Trainee Information
            $traineeInformations = $current_user;

            //2. Sync latest information to DB and get from DB
            $this->traineeSyncService->syncTraineeTrainingInformation($current_user);
            $traineeTrainingInformations = TraineeTrainingHistory::where('trainee_id', $current_user->id)->first();
            return response()->json([
                'trainee_information'          => $traineeInformations,
                'trainee_training_information' => $traineeTrainingInformations ?? "No Information.",
                'latest_training_information' => getNewestTrainingInformationOfTrainee($current_user->id),
                'skills_passport_card' => checkSkillPassportInformation($current_user->nic)
            ]);
        }
    }


    public function getUploadResume(Request $request) {
        if ($request->has('id')){
            $id = $request->id;
            $resume = Resume::where('id', $request->id)->first();
            return view('trainee.career-guidance.portfolio.upload-resume', compact('id', 'resume'));
        }else {
            return view('trainee.career-guidance.portfolio.upload-resume');
        }
    }

    public function postUploadResume(Request $request) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'attachment' => ($request->action == 'add') ? ['required', \Illuminate\Validation\Rules\File::types(['doc', 'docx', 'pdf'])->max('2gb')] : '',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $old_attachment = '';
        if ($request->action == 'add') {
            $result = new Resume();
        }elseif ($request->action == 'edit') {
            $result = Resume::where('id', $request->id)->first();
            $old_attachment = $result->attachment;
            if (!$result) {
                return redirect()->route('trainee.career-guidance.portfolio.get-resume')->withErrors(trans('system.information.content_management.not_found'));
            }
        }
        $result->trainee_id = Auth::guard('trainee')->user()->id;

        if ($request->has('attachment')) {
            $file = $request->file('attachment');
            $safeName = \Illuminate\Support\Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());
            $storage_path = storage_path('app/public/'.activeGuard().'/career-guidance/resume/'.Auth::guard(activeGuard())->user()->id.'/');
            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }
            $file->move($storage_path, $safeName);
            $path = 'storage/'.activeGuard().'/career-guidance/resume/'.Auth::guard(activeGuard())->user()->id.'/'.$safeName;
            $result->attachment = $path;
        }
        if ($result->save()) {
            if ($old_attachment != '' && is_file($old_attachment)) {
                unlink($old_attachment);
            }
            return redirect()->route('trainee.career-guidance.portfolio.get-resume')->with('success', trans('system.information.content_management.saved'));
        }
    }
    public function previewResume(Request $request) {
        $id = base64_decode($request->cid);
        $trainee = Auth::guard('trainee')->user();
        if (!$trainee) {
            abort(404);
        }
        $resume = Resume::where('id', $id)->where('trainee_id', $trainee->id)->first();
        if ($resume) {
            $resumeDir = storage_path('app/public/'.activeGuard().'/career-guidance/resume/');
            // Defence-in-depth: if the path resolves, ensure it stays inside the resume dir.
            // (Don't fail closed when realpath can't resolve — the symlink may be absent on some
            // hosts; ownership scoping above is the primary control.)
            $realPath = realpath($resume->attachment);
            $realResumeDir = realpath($resumeDir);
            if ($realPath !== false && $realResumeDir !== false && !str_starts_with($realPath, $realResumeDir)) {
                abort(404);
            }
            if (file_exists($resume->attachment)) {
                return response()->file($resume->attachment);
            }
        }else {
            return redirect('homepage')->withErrors('Can not find file!');
        }
    }

//    public function create()
//    {
//        // Check if portfolio exists
//        if (Portfolio::where('trainee_id', Auth::id())->exists()) {
//            return redirect()->route('portfolio.show');
//        }
//
//        return view('portfolio.create');
//    }

    public function show()
    {
        $portfolio = Portfolio::where('trainee_id', Auth::guard('trainee')?->id())->latest()->first();
        if($portfolio) {
            $portfolioDatas = $portfolio->data;
            return view('portfolio.show', compact('portfolioDatas', 'portfolio'));
        }else {
            return redirect()->route('trainee.career-guidance.portfolios.create');
        }

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
        $portfolio = Portfolio::updateOrCreate(
            ['trainee_id' => Auth::guard('trainee')->id() ?? auth()->guard('trainee')->id()],
            ['data' => $validated]
        );

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
        ]);

        $portfolio->update([
            'data' => array_merge($portfolio->data, $validated)
        ]);

        return response()->json($portfolio);
    }
}
