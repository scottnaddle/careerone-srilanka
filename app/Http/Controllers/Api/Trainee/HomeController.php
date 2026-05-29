<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Enums\JobStatusEnum;
use App\Enums\StatusEnumsManagement;
use App\Http\Controllers\Controller;
use App\Models\CareerGuidanceCategory;
use App\Models\Event;
use App\Models\Job;
use App\Models\Popup;
use App\Models\Sector;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeInformationService;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
class HomeController extends BaseController
{
    public $traineeInformationService;
    public function __construct(TraineeInformationService $traineeInformationService) {
        $this->traineeInformationService = $traineeInformationService;
    }
    public function index() : JsonResponse
    {
//        $events = Event::where('status', StatusEnumsManagement::APPROVED->value)
//            ->where('show_on_homepage', true)
//            ->when(
//                Event::where('status', StatusEnumsManagement::APPROVED->value)
//                    ->where('show_on_homepage', true)
//                    ->where('sort', '!=', 0)
//                    ->doesntExist(),
//                function ($query) {
//                    // Nếu tất cả sort đều là 0
//                    $query->orderBy('id', 'desc')->take(4);
//                },
//                function ($query) {
//                    // Nếu có sort khác 0
//                    $query->orderBy('sort', 'asc')->take(4);
//                }
//            )
//            ->get();
        $mainEvent = Event::where('status', StatusEnumsManagement::APPROVED->value)
            ->where('is_main_event',true)
            ->inRandomOrder()->first();
        if (!$mainEvent) {
            $mainEvent = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->latest()->first();
            $newestEvents = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->where(function (Builder $query) {
                    $query->where('is_main_event', false)
                        ->orWhereNull('is_main_event');
                })
                ->where('id', '!=', $mainEvent->id)
                ->latest('created_at')->take(3)
                ->get();
        }else {
            $newestEvents = Event::where('status', StatusEnumsManagement::APPROVED->value)
                ->where(function (Builder $query) {
                    $query->where('is_main_event', false)
                        ->orWhereNull('is_main_event');
                })
                ->latest('created_at')->take(3)
                ->get();
        }
        $events = collect();

        if ($mainEvent) {
            $events->push($mainEvent);
        }

        $events = $events->merge($newestEvents);
        foreach ($events as  $event) {
            $event->author_name = $event->author->fullName;
            $event->thumbnail = asset($event->thumbnail);
            $event->short_description = mb_convert_encoding(substr(strip_tags($event->details), 0, 180), 'UTF-8', 'auto');
            $event->short_description = preg_replace('/data:image\/[a-zA-Z]*;base64,[^\"]*/', '', $event->short_description);
            if (mb_strlen($event->details) > 200) {
                $event->short_description .= "...";
            }
            if ($event->attachments->count() > 0) {
                foreach ($event->attachments as $attachment) {
                    $attachment->path = asset('storage/'.$attachment->path);
                }
            }
        }
        $jobs = Job::query();
        $jobs->where('status', JobStatusEnum::PROGRESS->value);
        $recent_jobs = $jobs->where('status', JobStatusEnum::PROGRESS->value)
            ->whereHas('company', function ($query) {
                $query->whereNotNull('verified_at');
                $query->whereNotNull('verified_by');
            })
            ->latest()
            ->take(4)
            ->get();
        foreach ($recent_jobs as $job) {
            $job->company_name = $job->company->name;
            $job->company_logo = filter_var($job->company->logo, FILTER_VALIDATE_URL) ? $job->company->logo : (file_exists($job->company->logo) ? asset($job->company->logo) : '');
        }
        $now = Carbon::now();
        $today = $now->toDateString();

        $popups = Popup::where('status', 'active')
            ->where(function ($q) use ($today) {
                $q->whereNull('start_time')
                    ->orWhereDate('start_time', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_time')
                    ->orWhereDate('end_time', '>=', $today);
            })
            ->get();
        if (count($popups) > 0) {
            foreach ($popups as $popup) {
                if ($popup && $popup->image) {
                    $popup->image = asset('storage/' . $popup->image);
                }
            }
        }

        $contentCategory = CareerGuidanceCategory::first();

        $contentsQuery = $contentCategory->contentApproved()->inRandomOrder();

        $contents = $contentsQuery->take(4)->get();

        if (count($contents) > 0) {
            foreach ($contents as $content) {
                if($content->thumbnail != '') {
                    $content->thumbnail = asset($content->thumbnail);
                }
                if ($content->content_type != 'video') {
                    $attachments = json_decode($content->attachment_details, true);
                    if (is_array($attachments)) {
                        $attachments['path'] = asset($attachments['path']);
                        $content->attachment_details = $attachments;
                    }
                }
            }
        }
        $data['data']['popups'] = $popups;
        $data['data']['user'] = null;
        if (auth('sanctum')->check()) {
            $data['data']['user'] = auth('sanctum')->user();
        }
        $data['data']['events'] = $events;
        $data['data']['jobs'] = $recent_jobs;
        $data['data']['contents']['id'] = $contentCategory->id;
        $data['data']['contents']['name'] = $contentCategory->name;
        $data['data']['contents']['data'] = $contents;

        foreach ($data['data']['events'] as $event) {
            $event->thumbnail = asset($event->thumbnail);
        }
        foreach ($data['data']['jobs'] as $job) {
            $job->logo = asset($job->company->logo);
        }

        $sectors = array(
            ['name' => 'ICT', 'thumbnail' => asset('images/sector/ict_small.webp'),  'url' => route('sector.ict')],
            ['name' => 'Tourism', 'thumbnail' => asset('images/sector/tourism_small.webp'), 'url' => route('sector.tourism')],
            ['name' => 'Manufacturing', 'thumbnail' => asset('images/sector/manufacturing_small.webp'), 'url' => route('sector.manufactoring')],
            ['name' => 'Construction', 'thumbnail' => asset('images/sector/construction_small.webp'), 'url' => route('sector.construction')],
        );
        $guidelines = array(
            ['name' => 'Trainee', 'url' => route('guideline.guideline').'#trainee'],
            ['name' => 'CGO', 'url' => route('guideline.guideline').'#cgo'],
            ['name' => 'Company', 'url' => route('guideline.guideline').'#company'],
        );
        $data['data']['sectors'] = $sectors;
        $data['data']['guideline'] = $guidelines;
        return $this->sendResponse($data, 'Success');
    }
//    public function checkNIC(Request $request) : JsonResponse
//    {
//        if (TraineeUser::where('nic', $request->nic)->first()) {
//            return $this->sendError('NIC checking false.', ['error' => 'The account with NIC: ' . $request->nic . ' has existed!']);
//        }
//        $traineeInformation = $this->traineeInformationService->getTraineeInformation($request->nic);
//        $data['data'] = $traineeInformation['message'];
//        if ($traineeInformation['message'] != 'No Information.') {
//            return $this->sendResponse($data, 'Success');
//        }
//        return $this->sendError($data, 'NIC confirm fail!');
//    }

    public function checkNIC(Request $request)
    {
        if (TraineeUser::where('nic', $request->nic)->exists()) {
            return $this->sendError('The account with NIC: '.$request->nic.' already exists!', ['error' => 'The account with NIC: '.$request->nic.' already exists!', 'exists' => '1']);
        }
        $traineeInformation = $this->traineeInformationService->getTraineeInformation($request->nic);
        $data['data'] = $traineeInformation['message']  ?? [];

        if (isset($traineeInformation['message']) && $traineeInformation['message'] != 'No Information.') {
            $data['data']['exists'] = '0';
            return $this->sendResponse($data, 'Success');
        }

        return $this->sendError('No information.', ['error' => $traineeInformation['message'] ?? 'Can not get information from TVEC', 'exists' => '0']);
    }
}
