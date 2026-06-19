<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\CareerExpertInterview;
use App\Models\CareerGuidanceCategory;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\JobInformation;
use App\Models\SchoolKid;
use App\Models\Sector;
use App\Models\TraineeUser;
use App\Services\ContentViewLoggerService;
use Illuminate\Http\Request;
use Vish4395\LaravelFileViewer\LaravelFileViewer;
class CareerGuidanceController extends Controller
{
    public function getJobInformation(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $key_sector=$request->input('sector', '');
        $sectors = Sector::all();
        $jobsQuery = JobInformation::query();

        if ($keyword) {
            $jobsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'ILIKE', '%' . $keyword . '%');
            });
        }else if($key_sector){
            $jobsQuery->where('sector_id',  $key_sector );
        }
        $count = $jobsQuery->count();
        $jobs = $jobsQuery->paginate(8);

        return view('career-guidance.job-career-information.job-information', compact('sectors', 'jobs', 'count', 'keyword'));
    }


    public function getJobInformationDetails($slug)
    {
        $job = JobInformation::where('slug', 'ILIKE', '%' . $slug . '%')->first();
        if ($job) {
            return view('career-guidance.job-career-information.job-details', compact('job'));
        } else {
            return back()->withErrors('Can not find this job!');
        }
    }
    public function getCareerExpertInterview(Request $request)
    {

        $query = CareerExpertInterview::query();
        if ($request->has('search') && $request->query('search')) {
            $query->where('title', 'ILIKE', '%' . $request->query('search') . '%');
        }
        $query->orderBy('created_at', 'desc');
        $careerExpertInterviews = $query->paginate(8);
        $careerExpertInterviews->appends($request->all());
        return view('career-guidance.job-career-information.career-expert-interview')->with(['careerExpertInterviews' => $careerExpertInterviews]);
    }
    public function getCareerGuide(Request $request)
    {
        $careerGuideCategories = CareerGuidanceCategory::paginate(4);
        $tabId = $request->query('tab', 1);
        $category = CareerGuidanceCategory::where('id', $tabId)->first();
        if ($category) {
            $result = $category->contents;
        }else {
            $result = [];
        }
        return view('career-guidance.career-guide.career-guide')->with(['tabs' => $careerGuideCategories, 'tabId' => $tabId, 'results' => $result]);
    }

    public function getCareerGuideByCategoryId($id)
    {
        $category = CareerGuidanceCategory::where('id', $id)->first();
        if ($category) {
            $result = $category->careerGuidances()->paginate(10);
            return view('career-guidance.career-guide.view-all')->with(['results' => $result, 'category' => $category]);
        } else {
            return back()->withErrors('Can not find the category');
        }
    }


    public function getContents($categoryId, Request $request) {
        $keyword = $request->has('search') ? $request->search : '';
        $categoryId = base64_decode($categoryId);

        // Get category information
        $category = CareerGuidanceCategory::where('id', $categoryId)->firstOrFail();

        // Get the list of approved content
        $contentsQuery = $category->contentApproved()->latest();

        // Filter by keyword if provided
        if (!empty($keyword)) {
            $contentsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('intro', 'LIKE', "%$keyword%");
            });
        }

        // Get the data
        $contents = $contentsQuery->paginate(9); // or ->get() if pagination is not needed

        return view('career-guidance.job-career-information.content-list', compact('contents', 'category', 'keyword'));
    }

    public function getContentDetails($contentId, ContentViewLoggerService $logger) {
        $contentId = base64_decode($contentId);
        $writeLog = $logger->logView('content', $contentId);
        $content = Content::where('id', $contentId)->first();
        if ($content) {
            $user = $this->getAuthorContent($content->system, $content->created_by);
            $content->author = $user;
            foreach ($content->comments as $item) {
                $user = $this->getAuthorContent($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorContent($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }
            return view('career-guidance.job-career-information.content-detail', compact('content'));
        }else {
            return back()->withErrors('Can not find the content');
        }

    }

    public function previewFile($contentId)
    {
        $content = Content::find($contentId);

        if (!$content || !$content->attachment_details) {
            return 'Cannot find the content';
        }

        $file = json_decode($content->attachment_details);

        if (!isset($file->path)) {
            return 'Invalid file path';
        }

        $relativePath = str_replace('storage/', '', $file->path);
        $filePath = storage_path('app/public/' . $relativePath);

        \Log::info('Resolved file path: ' . $filePath);

        if (!file_exists($filePath)) {
            \Log::error("File not found at: $filePath");
            return response()->json(['error' => 'File not found.'], 404);
        }

        $fileUrl = asset($file->path);
        $fileName = $file->filename ?? basename($file->path);
        $disk = 'public';

//        $fileData = [
//            ['label' => __('Label'), 'value' => 'Value'],
//        ];

//        dd($fileName, $filePath, $fileUrl, $disk, $fileData);
        return LaravelFileViewer::show($fileName, $relativePath, $fileUrl, $disk);
    }

    public function getAuthorContent($system, $id)
    {
        $user = null;
        switch ($system) {
            case 'cgo':
                $user = CgoUser::where(['id' => $id])->first();
                break;
            case 'company':
                $user = CompanyRecruiter::where(['id' => $id])->first();
                break;
            case 'admin':
                $user = AdminUser::where(['id' => $id])->first();
                break;
            case 'trainee':
                $user = TraineeUser::where(['id' => $id])->first();
                break;
            case 'schoolkid':
                $user = SchoolKid::where(['id' => $id])->first();
                break;
        }
        return $user;
    }
}
