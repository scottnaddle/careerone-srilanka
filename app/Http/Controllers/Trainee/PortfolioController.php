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
        $this->middleware('trainee.auth')->except('previewResume', 'previewPortfolio','show');
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
//    public function createPortfolio() {
//        if (Portfolio::where('trainee_id', Auth::guard('trainee')->user()->id)->exists()) {
//            return redirect()->route('trainee.career-guidance.portfolio.get-portfolio')->withErrors( "Your portfolio has existed!");
//        }
//        $portfolioDatas = array(
//            'fullname' => 'Luu Nguyen',
//            'description' => 'I am the best of electric',
//            'summary' => 'Web Designer | NVQ5 | Tourism',
//            'basic_information' => [
//                'fullname' => 'Luu Nguyen',
//                'email' => 'oscar@videabiz.com',
//                'phone' => '0356465883',
//                'address' => '37403 Haven Locks Predovichaven, KY 12472-2496'
//            ],
//            'about_me' => 'I have many dreams to grow as a technical expert in TVET sector in Sri Lanka. I want to grow as a professional with specialized skills.',
//            'tvec_educations' => array(
//                [
//                    'institute' => 'Sri Lanka Forestry Institute',
//                    'industry_sector' => '(A) Agriculture, Hunting and Forestry',
//                    'course_name' => 'Forestry',
//                    'from' => '2017-01-02',
//                    'to' => '2018-01-02'
//                ],
//                [
//                    'institute' => 'Sri Lanka Forestry Institute',
//                    'industry_sector' => '(A) Agriculture, Hunting and Forestry',
//                    'course_name' => 'Forestry',
//                    'from' => '2017-01-02',
//                    'to' => '2018-01-02'
//                ]
//            ),
//            'nvq_educations' => array(
//                [
//                    'qualification_name' => 'Forestry',
//                    'effective_date' => '2021-07-27',
//                    'level' => 'L6',
//                ],
//            )
//            ,
//            'educations' => array(
//                [
//                    'school_name' => 'Primary School',
//                    'district' => 'D10',
//                    'province' => 'Colombo',
//                    'from' => '2022-09-09',
//                    'to' => '2023-09-09'
//                ],
//                [
//                    'school_name' => 'Secondary School',
//                    'district' => 'D10',
//                    'province' => 'Colombo',
//                    'from' => '2023-09-09',
//                    'to' => '2024-09-09'
//                ],
//                [
//                    'school_name' => 'High School',
//                    'district' => 'D10',
//                    'province' => 'Colombo',
//                    'from' => '2024-09-09',
//                    'to' => '2026-09-09'
//                ],
//            ),
//            'ojt_experiences' => array(
//                [
//                    'time' => 'April 2022',
//                    'ojt_name' => 'Completed an OJT course of AWS',
//                    'ojt_description' => 'Get started with dozens of web components and interactive elements built on top of Tailwind CSS.'
//                ],
//                [
//                    'time' => 'March 2022',
//                    'ojt_name' => 'Completed an OJT course of Figma',
//                    'ojt_description' => 'All of the pages and components are first designed in Figma and we keep a parity between the two versions even as we update the project.'
//                ],
//                [
//                'time' => 'April 2022',
//                'ojt_name' => 'Completed web development training',
//                'ojt_description' => 'Get access to over 20+ pages including a dashboard layout, charts, kanban board, calendar, and pre-order E-commerce & Marketing pages.'
//                ]
//            ),
//            'experiences' => array(
//                [
//                    'time' => 'April 2022',
//                    'experience_name' => 'E-Commerce UI code in Tailwind CSS',
//                    'experience_description' => 'Get started with dozens of web components and interactive elements built on top of Tailwind CSS.'
//                ],
//                [
//                    'time' => 'March 2022',
//                    'experience_name' => 'Marketing UI design in Figma',
//                    'experience_description' => 'All of the pages and components are first designed in Figma and we keep a parity between the two versions even as we update the project.'
//                ],
//                [
//                    'time' => 'April 2022',
//                    'experience_name' => 'Application UI code in Tailwind CSS',
//                    'experience_description' => 'Get access to over 20+ pages including a dashboard layout, charts, kanban board, calendar, and pre-order E-commerce & Marketing pages.'
//                ]
//            ),
//            'skills' => array(
//                [
//                    'name' => 'Administration',
//                    'description' => 'Human Resources Administrator at Point Avenue'
//                ],
//                [
//                    'name' => 'Administration',
//                    'description' => 'Human Resources Administrator at Point Avenue'
//                ]
//            ),
//            'languages' => [
//               'english','tamil','sinhala'
//            ],
//            'evidences' => array(
//                [
//                    'name' => 'Certificate of Completion ICT Training OJT',
//                    'attachment_path' => '/images/certificate-sample.webp',
//                    'time' => '2023-2024',
//                    'description' => 'This training enhanced the trainee’s practical knowledge in areas such as networking, programming, database management, and IT support. It also helped improve their problem-solving skills, communication abilities, and adaptability in a dynamic work setting.'
//                ]
//            )
//        );
//        return view('portfolio.template.linkedin', compact('portfolioDatas'));
//    }
    public function create()
    {
        // Check if portfolio already exists
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

        // Initialize default values
        $tvecEducations = [];
        $nvqEducations = [];

        // Process TVEC educations
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

        // Process NVQ educations
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

        return view('portfolio.create', compact('portfolioData'));
    }
    public function edit()
    {
        // Check if portfolio already exists
        if ($portfolio = Portfolio::where('trainee_id', Auth::guard('trainee')->id())->first()) {

            $portfolioData = $portfolio->data;

            return view('portfolio.create', compact('portfolioData'));
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

        if (isset($jsonData['pid']) && $jsonData['pid'] != '') {
            $portfolio = Portfolio::where('id', $jsonData['pid'])->first();
        } else {
            $portfolio = new Portfolio();
        }

        // Ensure each key exists before assigning
        $portfolio->data = json_encode($jsonData['data'] ?? []); // Store as JSON string
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
            unlink($result->attachment);
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

            $fullNameSlug = \Str::slug(Auth::guard('trainee')->user()->fullName);
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
            // Check if trainee allows public portfolio sharing
            $trainee = TraineeUser::find($portfolio->trainee_id);
            if ($trainee && !$trainee->public_portfolio) {
                return back()->withErrors('This portfolio is not publicly available.');
            }
            $portfolioDatas = $portfolio->data;
            return view('portfolio.preview', compact('portfolioDatas', 'portfolio'));
        } else {
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
            $fullName = $file->getClientOriginalName();
            $storage_path = storage_path('app/public/'.activeGuard().'/career-guidance/resume/'.Auth::guard(activeGuard())->user()->id.'/');
            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }
            $file->move($storage_path, $fullName);
            $path = 'storage/'.activeGuard().'/career-guidance/resume/'.Auth::guard(activeGuard())->user()->id.'/'.$fullName;
            $result->attachment = $path;
        }
        if ($result->save()) {
            if ($old_attachment != '') {
                unlink($old_attachment);
            }
            return redirect()->route('trainee.career-guidance.portfolio.get-resume')->with('success', trans('system.information.content_management.saved'));
        }
    }
    public function previewResume(Request $request) {
        $id = base64_decode($request->cid);
        $resume = Resume::where('id', $id)->first();
        if ($resume) {
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
        $portfolio = Portfolio::where('trainee_id', Auth::guard('trainee')?->id())->first();
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
        if ($portfolio = Portfolio::where('trainee_id', auth()->guard('trainee')->id())->first()) {
            $portfolio->data = $validated;
            $portfolio->save();
        }else {
            $portfolio = Portfolio::create([
                'trainee_id' => Auth::guard('trainee')->id(),
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
        ]);

        $portfolio->update([
            'data' => array_merge($portfolio->data, $validated)
        ]);

        return response()->json($portfolio);
    }

    public function generatePortfolios()
    {
        // Get all active trainee NICs from database
        $nic = TraineeUser::where('active', true)->pluck('nic')->toArray();

        if (empty($nic)) {
            return response()->json([
                'message' => 'No active trainees found.',
            ], 404);
        }

        // Dispatch job to process in queue
        CreatePortfoliosJob::dispatch($nic);

        return response()->json([
            'message' => 'Portfolio generation job has been dispatched for ' . count($nic) . ' trainees.',
        ]);
    }
}
