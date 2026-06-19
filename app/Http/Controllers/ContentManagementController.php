<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnumsManagement;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\CareerGuidanceCategory;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\ContentComment;
use App\Models\PeerContentReview;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use App\Services\Cgo\AutoAssignPeerReviewContentService;
use App\Services\Cgo\NotificationManager;
use App\Services\ContentViewLoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mostafaznv\PdfOptimizer\PdfOptimizer;
use Illuminate\Support\Facades\URL;
class ContentManagementController extends Controller
{
    private $modelContent;

    public function __construct()
    {
        $this->modelContent = new Content();
    }
    public function getVideos(Request $request) {
        //Get by slug
        if ($request->slug != '') {
            $video = Content::where('content_type', 'video')->where('slug', $request->slug)->where('system', 'cgo')->first();
            $msg = '';
            if ($video == ''){
                $msg = 'Not found';
            }
            return [
                'status' => true,
                'data' => $video,
                'message' => $msg
            ];
        }
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $status = $request->has('status') ? $request->status : 'all';
        $order = $request->has('order') ? $request->order : 'desc';
        $count = 0;
        $videos = Content::query();
        $videos->where('content_type', 'video')->where('system', activeGuard())->where('created_by', Auth::guard(activeGuard())->user()->id);
        if ($request->has('keyword')) {
            $videos->where('title', 'ILIKE', '%'. $request->keyword . '%');
        }
        if ($request->has('status')) {
            if ($request->status != 'all') {
                $videos->where('status', $request->status);
            }
        }
        $videos->orderBy('created_at', $order);
        $count = $videos->count();
        $videos = $videos->paginate(8)->appends(request()->query());
        $categories = CareerGuidanceCategory::all();
        return view('informations.content-management.videos', compact('videos', 'status', 'keyword','count','order', 'categories'));
    }

    public function postVideos(Request $request, AutoAssignPeerReviewContentService $autoAssignPeerReviewContentService) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'video_url' => ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'intro' => 'required',
            'action' => 'required',
            'thumbnail' => 'mimes:jpeg,png,jpg|max:51200'
        ],
            [
                'intro.required' => 'The content introduction field is required.'
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if ($request->action == 'add') {
            $video = new Content();
        }elseif ($request->action == 'edit') {
            $videoQuery = Content::where('content_type', 'video')
                ->where('id', $request->id);

//            if (activeGuard() != '' && Auth::guard(activeGuard())->check()) {
//                $videoQuery->where('created_by', Auth::guard(activeGuard())->id());
//                $videoQuery->where('system', activeGuard());
//            }

            $video = $videoQuery->first();
            PeerContentReview::where('content_id', $request->id)->delete();
            if (!$video) {
                return redirect()->route(activeGuard().'.informations.content-management.videos.list')->withErrors(trans('system.information.content_management.not_found'));
            }
        }
        $previousUrl = URL::previous();
        $video->title = $request->title;
        $video->slug = \Str::slug($request->title, '-', 'ta');
        $video->content_type = 'video';
        $video->video_url = $request->video_url;
        $video->intro = $request->intro;
        if ($request->action == 'edit' && auth('admin')->check() && \Str::contains($previousUrl, 'admin')) {
            $video->status = \App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value;
        }else {
            $video->status = \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value;
            $video->system = activeGuard();
            $video->created_by = Auth::guard(activeGuard())->user()->id;
        }
        $video->attachment_details = json_encode([]);

        $video->category_id = $request->category;
        if ($video->save()) {
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $path = saveImageAsWebp($thumbnail, 'contents/thumbnails/' . $video->id);
                $video->update(['thumbnail' => $path]);
            }
//            if (activeGuard() == 'cgo') {
//                $autoAssignPeerReviewContentService->assign($video);
//            }

            if ($request->action == 'edit' && auth('admin')->check() && \Str::contains($previousUrl, 'admin')) {
                return redirect('/admin/content/videos');
            }
            return redirect()->route(activeGuard().'.informations.content-management.videos.list')->with('success', trans('system.information.content_management.saved'));
        }
    }
    public function deleteVideo($slug) {
        $video = Content::where('created_by', Auth::guard(activeGuard())->user()->id)->where('slug','ILIKE', '%'.$slug.'%')->first();
        if ($video) {
            $video->peerReview()->delete();
            $video->comments()->delete();
            $video->delete();
            return redirect()->route(activeGuard().'.informations.content-management.videos.list')->with('success', 'DELETED!');
        }else {
            return redirect()->route(activeGuard().'.informations.content-management.videos.list')->withErrors(trans('system.information.content_management.not_found'));
        }
    }
    public function deleteDocument($id) {
        $document = Content::where('created_by', Auth::guard(activeGuard())->user()->id)->where('id', $id)->first();

        if ($document) {
            $attachment_details = json_decode($document->attachment_details);
            if (isset($attachment_details->path)) {
                $path = storage_path('app/' . ltrim($attachment_details->path, '/'));
                if (file_exists($path)) {
                    @unlink($path); // @ to suppress the warning if the file does not exist
                }
            }
            $document->peerReview()->delete();
            $document->comments()->delete();
            $document->delete();
            return redirect()->route(activeGuard().'.informations.content-management.documents.list')->with('success', trans('system.information.content_management.deleted'));
        }else {
            return redirect()->route(activeGuard().'.informations.content-management.documents.list')->withErrors(trans('system.information.content_management.not_found'));
        }
    }
    public function getDocuments(Request $request) {
        //Get by id
        if ($request->id != '') {
            $document = Content::where('content_type', 'not like', 'video')->where('id', $request->id)->where('system', activeGuard())->where('created_by', Auth::guard(activeGuard())->user()->id)->first();
            $msg = '';
            if ($document == ''){
                $msg = 'Not found';
            }
            return [
                'status' => true,
                'data' => $document,
                'message' => $msg
            ];
        }
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $status = $request->has('status') ? $request->status : 'all';
        $order = $request->has('order') ? $request->order : 'desc';
        $count = 0;
        $documents = Content::query();
        $documents->where('content_type', 'not like', 'video')->where('system', activeGuard())->where('created_by', Auth::guard(activeGuard())->user()->id);
        if ($request->has('keyword')) {
            $documents->where('title', 'ILIKE', '%'. $request->keyword . '%');
        }
        if ($request->has('status')) {
            if ($request->status != 'all') {
                $documents->where('status', $request->status);
            }
        }
        $documents->orderBy('created_at', $order);
        $count = $documents->count();
        $documents = $documents->paginate(8)->appends(request()->query());
        $categories = CareerGuidanceCategory::all();
        return view('informations.content-management.documents', compact('documents', 'status', 'keyword','count','order', 'categories'));
    }

//    public function postDocument(Request $request, AutoAssignPeerReviewContentService $autoAssignPeerReviewContentService) {
//        // validate incoming request
//        $validator = \Validator::make($request->all(), [
//            'title' => 'required|max:255',
//            'intro' => 'required',
//            'action' => 'required',
//            'attachment' => ($request->action == 'add') ? ['required', \Illuminate\Validation\Rules\File::types(['doc', 'docx', 'pdf'])->max('2gb')] : '',
//            'thumbnail' => 'mimes:jpeg,png,jpg|max:51200'
//        ],[
//            'intro.required' => 'The content introduction field is required.'
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator);
//        }
//        if ($request->action == 'add') {
//            $document = new Content();
//        }elseif ($request->action == 'edit') {
//            $document = Content::where('content_type','not like', 'video')->where('created_by', Auth::guard(activeGuard())->user()->id)->where('id', $request->id)->where('system', activeGuard())->first();
//            PeerContentReview::where('content_id', $request->id)->delete();
//            if (!$document) {
//                return redirect()->route(activeGuard().'.informations.content-management.documents.list')->withErrors(trans('system.information.content_management.not_found'));
//            }
//        }
//        $document->title = $request->title;
//        $document->slug = \Str::slug($request->title);
//        $document->intro = $request->intro;
//        $document->status = \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value;
//        $document->author = $request->author;
//        $document->license = $request->license;
//        $document->category_id = $request->category;
//        if ($request->has('attachment')) {
//            $file = $request->file('attachment');
//            $mimeType = $file->getMimeType();
//            switch ($mimeType) {
//                case 'application/msword':
//                    $fileType = 'doc';
//                    break;
//                case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
//                    $fileType = 'docx';
//                    break;
//                case 'application/pdf':
//                    $fileType = 'pdf';
//                    break;
//                default:
//                    $fileType = 'Unknown';
//            }
//
//            $document->content_type = $fileType;
//            $document->size = number_format($request->file('attachment')->getSize() / 1048576,2)." MB";
//            $fullName = $file->getClientOriginalName();
//            $storage_path = storage_path('app/public/'.activeGuard().'/content-management/documents/'.Auth::guard(activeGuard())->user()->id.'/');
//            if (!Storage::exists($storage_path)) {
//                Storage::makeDirectory($storage_path);
//            }
//            $file->move($storage_path, $fullName);
//            $path = 'storage/'.activeGuard().'/content-management/documents/'.Auth::guard(activeGuard())->user()->id.'/'.$fullName;
//            $document->attachment_details = json_encode([
//                'filename' => $fullName,
//                'path' => $path,
//                'size' => $document->size
//            ]);
//
//        }
//
//        $document->system = activeGuard();
//        $document->created_by = Auth::guard(activeGuard())->user()->id;
//        if ($document->save()) {
//            if ($request->hasFile('thumbnail')) {
//                $thumbnail = $request->file('thumbnail');
//                $path = saveImageAsWebp($thumbnail, 'contents/thumbnails/' . $document->id);
//                $document->update(['thumbnail' => $path]);
//            }
//            if (activeGuard() == 'cgo') {
////                $autoAssignPeerReviewContentService->assign($document);
//            }
//
//            return redirect()->route(activeGuard().'.informations.content-management.documents.list')->with('success', trans('system.information.content_management.saved'));
//        }
//    }
    public function postDocument(Request $request, AutoAssignPeerReviewContentService $autoAssignPeerReviewContentService)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'intro' => 'required',
            'action' => 'required',
            'attachment' => ($request->action == 'add')
                ? ['required', \Illuminate\Validation\Rules\File::types(['doc', 'docx', 'pdf'])->max('2gb')]
                : '',
            'thumbnail' => 'mimes:jpeg,png,jpg|max:51200'
        ], [
            'intro.required' => 'The content introduction field is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = Auth::guard(activeGuard())->user();

        $document = ($request->action === 'edit')
            ? Content::where('content_type', 'not like', 'video')
                ->where('created_by', $user->id)
                ->where('id', $request->id)
                ->where('system', activeGuard())
                ->first()
            : new Content();

        if (!$document && $request->action === 'edit') {
            return redirect()->route(activeGuard() . '.informations.content-management.documents.list')
                ->withErrors(trans('system.information.content_management.not_found'));
        }

        if ($request->action === 'edit') {
            PeerContentReview::where('content_id', $request->id)->delete();
        }

        $document->fill([
            'title' => $request->title,
            'slug' => \Str::slug($request->title, '-', 'ta'),
            'intro' => $request->intro,
            'status' => StatusEnumsManagement::PENDING_APPROVAL->value,
            'author' => $request->author,
            'license' => $request->license,
            'category_id' => $request->category,
            'system' => activeGuard(),
            'created_by' => $user->id,
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $mimeType = $attachment->getMimeType();
            $fileType = match ($mimeType) {
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/pdf' => 'pdf',
                default => 'unknown'
            };

            $document->content_type = $fileType;
            $document->size = number_format($attachment->getSize() / 1048576, 2) . " MB";

            $filename = $attachment->getClientOriginalName();
            $userStoragePath = 'public/' . activeGuard() . '/content-management/documents/' . $user->id . '/';
            $absoluteStoragePath = storage_path('app/' . $userStoragePath);

            if (!Storage::exists($userStoragePath)) {
                Storage::makeDirectory($userStoragePath);
            }

            $finalFilePath = $absoluteStoragePath . $filename;

            if ($fileType === 'pdf') {
                $tempPath = $attachment->storeAs('temp-pdfs', uniqid() . '.pdf');
                $tempFullPath = storage_path('app/' . $tempPath);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    putenv('TEMP=D:/gs_temp');
                    putenv('TMP=D:/gs_temp');
                } else {
                    putenv('TMPDIR=/var/tmp/gs_tmp');
                }
                $gsPath = env('PDF_OPTIMIZER_GS');
                // Compress the PDF with Ghostscript
                PdfOptimizer::init($gsPath)->logger(\Log::getLogger())
                ->optimize($tempFullPath, $finalFilePath);

                Storage::delete($tempPath);
            } else {
                $attachment->move($absoluteStoragePath, $filename);
            }

            $document->attachment_details = json_encode([
                'filename' => $filename,
                'path' => 'storage/' . activeGuard() . '/content-management/documents/' . $user->id . '/' . $filename,
                'size' => $document->size
            ]);
        }

        if ($document->save()) {
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailPath = saveImageAsWebp($thumbnail, 'contents/thumbnails/' . $document->id);
                $document->update(['thumbnail' => $thumbnailPath]);
            }

//            if (activeGuard() === 'cgo') {
//                $autoAssignPeerReviewContentService->assign($document);
//            }

            return redirect()->route(activeGuard() . '.informations.content-management.documents.list')
                ->with('success', trans('system.information.content_management.saved'));
        }
    }
//    public function downloadDocument($id) {
//        $document = Content::where('id', $id)->first();
//        if ($document) {
//            $attachment_details = json_decode($document->attachment_details);
//            if (isset($attachment_details->path)) {
//                $path = $attachment_details->path;
//                return response()->download($path);
//            }
//        }
//        return redirect()->route(activeGuard().'.informations.content-management.documents.list')->withErrors(trans('system.information.content_management.not_found'));
//    }
    public function downloadDocument($id) {
        $document = Content::find($id);

        if ($document) {
            $attachmentDetails = json_decode($document->attachment_details);

            if (isset($attachmentDetails->path) && File::exists($attachmentDetails->path)) {
                $path = $attachmentDetails->path;

                // If it is a PDF, display it in the browser
                if ($document->content_type === 'pdf') {
                    return response()->file($path, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                    ]);
                }

                // If it is not a PDF, download it
                return response()->download($path);
            }
        }

        return redirect()
            ->route(activeGuard() . '.informations.content-management.documents.list')
            ->withErrors(trans('system.information.content_management.not_found'));
    }
    public function showReview(Request $request) {
        return view('informations.content-management.review-content');
    }
    public function listReviewContent(Request $request) {
        $contentNotApprovsal = Content::where('status', \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value)
                                       ->paginate(10);
        return view('informations.content-management.list-review-content', compact('contentNotApprovsal'));
    }
    public function contentDetail(Request $request,Content $content) {
        $content->attachment_details = json_decode($content->attachment_details, true);
        return view('informations.content-management.view-content', compact('content'));
    }

    public function getPeerReviewList(Request $request) {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $categoryId = $request->has('category') ? $request->category : 'all';
        $order = $request->has('order') ? $request->order : 'desc';
        $categories = CareerGuidanceCategory::all();
        $currentCgoId = Auth::guard('cgo')->id();
        $contents = PeerContentReview::query();
        $contents->where('cgo_user_id_1', $currentCgoId)
            ->orWhere('cgo_user_id_2', $currentCgoId)
            ->orWhere('cgo_user_id_3', $currentCgoId);
        if (!empty($keyword)) {
            $contents->whereHas('content', function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            });
        }
        if ($categoryId !== 'all') {
            $contents->whereHas('content', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }
        $contents->orderBy('created_at', $order);
        $count = $contents->count();
        $contents = $contents->paginate('10');

        return view('cgo.information.peer-review.list', compact('contents', 'keyword', 'order', 'categoryId', 'categories', 'count'));
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

    public function getPeerReviewContentDetails($id, $peer_id, ContentViewLoggerService $logger) {
        $id = base64_decode($id);
        $writeLog = $logger->logView('content', $id);
        $content = Content::where('id', $id)->first();
        $questionList = [
            'sn' => [
                [
                    'topic' => '1. අන්තර්ගතයේ ගුණාත්මකභාවය',
                    'q' => [
                        'නිවැරදිතාව: එය නවතම තොරතුරු ප‍්‍රකාශ කරයි ද?',
                        'ආස්ථාව: මූලාශ්‍ර පැහැදිලි හා විශ්වාසනීය ද?',
                        'සමන්තිය: අන්තර්ගතය යථාතත්‍ය සහතික කර තිබේ ද සහ ස්ථිර ප්‍රවාහයක් තිබේ ද?',
                        'කියවීමේ හැකියාව: එය පැහැදිලි සහ කෙටි වාක්‍ය වලින් ලියවී තිබේ ද, හොඳින් අවබෝධ කරගත හැකිද?'
                    ]
                ],
                [
                    'topic' => '2. නිර්මාණය',
                    'q' => [
                        'සංරචනය: අංග හොඳින් සකස් කර, කියවීමට පහසු ද?',
                        'දෘශ්‍යමය අංග: වර්ණ, රූප, චිත්‍ර, සටහන්, වගු, හා සටහන් වැනි අංග හොඳින් භාවිතා කරනවා ද?',
                        'අන්තර්ගතය පැහැදිලිව අවබෝධ කර ගැනීම: පරිශීලකයින්ට එය අවබෝධ කර ගැනීමට පහසු ද?',
                        'අංග සකස් කිරීම: මාතෘකාවන්, උපමාතෘකාවන් සහ අන්තර්ගතය ඇතුළුව, මුල් අංග සකස් කිරීම ප්‍රමුඛතාවයෙන් සිදු කර තිබේද?'
                    ]
                ],
                [
                    'topic' => '3. තාක්ෂණික පූර්ණතාවය',
                    'q' => [
                        'දෝෂ: ටයිප් වැරදි හෝ වැරදි පරිවර්තන තිබේ ද?',
                    ]
                ],
                [
                    'topic' => '4. අන්තර්ගතයේ අරමුණ සහ ක්‍රියාකාරිත්වය',
                    'q' => [
                        'මෙම අන්තර්ගතය තොරතුරු සපයනවාද සහ සිසුන් සඳහා ප්‍රවර්ධනය කිරීමේදී භාවිතා කළ හැකි ද?',
                    ]
                ],

            ],
            'en' => [
                [
                    'topic' => '1. Content Quality',
                    'q' => [
                        'Accuracy: Does it reflect the latest information?',
                        'Credibility: Are the sources clear and credible?',
                        'Coherence: Is the content logically connected and has a consistent flow?',
                        'Clarity & Readability: Is it written in clear, concise sentences that are easy to understand?'
                    ]
                ],
                [
                    'topic' => '2. Design & UI/UX',
                    'q' => [
                        'Layout: Are the components organized and readable?',
                        'Visual elements: Are colors, images, icons, tables and graph etc. used appropriately?',
                        'Intuitiveness: Is it easy for users to navigate and understand?',
                        'Intuitiveness: Is it easy for users to navigate and understand?'
                    ]
                ],
                [
                    'topic' => '3. Technical completeness',
                    'q' => [
                        'Error: Are there any typos or mistranslations?',
                    ]
                ],
                [
                    'topic' => '4. Purpose and effectiveness',
                    'q' => [
                        'Goal alignment: Is the content appropriate for the set goal (informational, promotional, etc.)?',
                    ]
                ],

            ],
            'tm' => [
                [
                    'topic' => '1. உள்ளடக்கதரம்',
                    'q' => [
                        'துல்லியம்: இது சமீபத்திய தகவலைப் பிரதிபலிக்கிறதா?',
                        'நம்பகத்தன்மை: ஆதாரங்கள் தெளிவாகவும் நம்பகமானதாகவும் உள்ளனவா?',
                        'ஒத்திசைவு: உள்ளடக்கம் தர்க்கரீதியாக இணைக்கப்பட்டு சீரான ஓட்டத்தைக் கொண்டிருக்கிறதா?',
                        'தெளிவு மற்றும் படிக்கக்கூடிய தன்மை: புரிந்துகொள்ள எளிதான தெளிவான, சுருக்கமான வாக்கியங்களில் எழுதப்பட்டுள்ளதா?'
                    ]
                ],
                [
                    'topic' => '2. வடிவமைப்பு (UI/UX)',
                    'q' => [
                        'தளவமைப்பு: கூறுகள் ஒழுங்கமைக்கப்பட்டு வாசிக்கக்கூடியதாக உள்ளதா?',
                        'காட்சி கூறுகள்: வண்ணங்கள், படங்கள், சின்னங்கள், அட்டவணைகள் மற்றும் வரைபடம் போன்றவை சரியான முறையில் பயன்படுத்தப்படுகின்றனவா?',
                        'உள்ளுணர்வு: பயனர்களை வழிநடத்துவதும் புரிந்துகொள்வதும் எளிதானதா?					',
                        'மையக் கூறுகளின் ஏற்பாடு: தலைப்புகள், துணைத் தலைப்புகள் மற்றும் உள்ளடக்கம் உள்ளிட்ட மையக் கூறுகளின் முன்னுரிமைப்படுத்தப்பட்ட ஏற்பாடு உள்ளதா?'
                    ]
                ],
                [
                    'topic' => '3. தொழில்நுட்ப முழுமை',
                    'q' => [
                        'பிழைகள்: ஏதேனும் எழுத்துப் பிழைகள் அல்லது மொழிபெயர்ப்புப் பிழைகள் உள்ளதா?',
                    ]
                ],
                [
                    'topic' => '4. நோக்கம் மற்றும் செயல்திறன்',
                    'q' => [
                        'இலக்கு சீரமைப்பு: நிர்ணயிக்கப்பட்ட இலக்கிற்கு உள்ளடக்கம் பொருத்தமானதா (இது தகவல் சார்ந்ததா மற்றும் மாணவர்களுக்கு விளம்பரப்படுத்தப் பயன்படுத்த முடியுமா)?',
                    ]
                ],

            ],

        ];
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
            $peerItem = PeerContentReview::find(base64_decode($peer_id));
            return view('cgo.information.peer-review.content-details', compact('content', 'questionList', 'peerItem'));
        }else {
            return back()->withErrors(trans('system.information.content_management.not_found'));
        }
    }


    public function submitResponse(Request $request) {
        $peerReviewitem = PeerContentReview::where('id', $request->peer_id)->first();
        $result = $request->except('_token', 'peer_id');

        $sum = 0;
        foreach ($result as $item) {
            $sum += (float) $item;
        }

        if ($peerReviewitem) {
            $currentUserId = Auth::guard('cgo')->id();

            if ($peerReviewitem->cgo_user_id_1 == $currentUserId) {
                $position = 1;
            } elseif ($peerReviewitem->cgo_user_id_2 == $currentUserId) {
                $position = 2;
            } elseif ($peerReviewitem->cgo_user_id_3 == $currentUserId) {
                $position = 3;
            } else {
                // User is not assigned to any of the 3 user_ids
                abort(403, 'You are not authorized to access this content.');
            }

            $resultField = "cgo_user_{$position}_result";
            $detailsField = "cgo_user_{$position}_result_details";

            // Access the data:
            $peerReviewitem->$resultField = $sum;
            $peerReviewitem->$detailsField = json_encode($result);
            $peerReviewitem->save();
            if (
                $peerReviewitem->cgo_user_1_result !== null &&
                $peerReviewitem->cgo_user_2_result !== null &&
                $peerReviewitem->cgo_user_3_result !== null &&
                $peerReviewitem->cgo_user_1_result_details !== null &&
                $peerReviewitem->cgo_user_2_result_details !== null &&
                $peerReviewitem->cgo_user_3_result_details !== null
            ) {
                $avg = (
                        (float) $peerReviewitem->cgo_user_1_result +
                        (float) $peerReviewitem->cgo_user_2_result +
                        (float) $peerReviewitem->cgo_user_3_result
                    ) / 3;

                $content = Content::find($peerReviewitem->content_id);
                if ($content) {
                    $content->status = $avg <= 75.0
                        ? StatusEnumsManagement::REJECTED_BY_PEER_REVIEW->value
                        : StatusEnumsManagement::APPROVED_BY_PEER_REVIEW->value;
                    $content->save();
                }
            }
            return redirect()->route('cgo.informations.content-management.peer-review.list');
        }
    }
}

