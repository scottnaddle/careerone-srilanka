<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class ContentManagementController extends Controller
{
    private $modelContent;

    public function __construct()
    {
        $this->middleware(activeGuard().'.auth');
        $this->modelContent = new Content();
    }
    public function getVideos(Request $request) {
        //Get by slug
        if ($request->slug != '') {
            $video = Content::where('type', 'video')->where('slug', $request->slug)->where('system', activeGuard())->first();
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
        $videos->where('type', 'video')->where('system', activeGuard())->where('created_by', Auth::guard(activeGuard())->user()->id);
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
        foreach ($videos as $video) {
            if (filter_var($video->video_url, FILTER_VALIDATE_URL)) {
                if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $video->video_url) === 1) {
                    $video_id = explode("?v=", $video->video_url);
                    $video_id = $video_id[1];
                    $video->video_thumbnail = 'https://img.youtube.com/vi/'.$video_id.'/sddefault.jpg';
                }else {
                    $video->video_thumbnail = '';
                }

            }
            switch ($video->status) {
                case 0:
                    $video->status = "Requested";
                    break;
                case 1:
                    $video->status = "Confirmed";
                    break;
                case 2:
                    $video->status = "Rejected";
                    break;
            }
        }
        return view(activeGuard().'.informations.content-management.videos', compact('videos', 'status', 'keyword','count','order'));
    }

    public function postVideos(Request $request) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'video_url' => ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'intro' => 'required',
            'action' => 'required',
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
            $video = Content::where('type', 'video')->where('created_by', Auth::guard(activeGuard())->user()->id)->where('id', $request->id)->where('system', activeGuard())->first();
            if (!$video) {
                return redirect()->route(activeGuard().'.informations.content-management.videos')->withErrors('Can not find this content or you do not have permission!');
            }
        }
        $video->title = $request->title;
        $video->slug = \Str::slug($request->title);
        $video->type = 'video';
        $video->video_url = $request->video_url;
        $video->intro = $request->intro;
        $video->status = 0;
        $video->attachment_details = json_encode([]);
        $video->system = activeGuard();
        $video->created_by = Auth::guard(activeGuard())->user()->id;
        if ($video->save()) {
            return redirect()->route(activeGuard().'.informations.content-management.videos')->with('success', 'SAVED!');
        }
    }
    public function deleteVideo($slug) {
        $video = Content::where('created_by', Auth::guard(activeGuard())->user()->id)->where('slug','ILIKE', '%'.$slug.'%')->first();
        if ($video) {
            $video->delete();
            return redirect()->route(activeGuard().'.informations.content-management.videos')->with('success', 'DELETED!');
        }else {
            return redirect()->route(activeGuard().'.informations.content-management.videos')->withErrors('We can not delete this content or you do not have permission!');
        }
    }
    public function deleteDocument($id) {
        $video = Content::where('created_by', Auth::guard(activeGuard())->user()->id)->where('id', $id)->first();
        if ($video) {
            $video->delete();
            return redirect()->route(activeGuard().'.informations.content-management.documents')->with('success', 'DELETED!');
        }else {
            return redirect()->route(activeGuard().'.informations.content-management.documents')->withErrors('We can not delete this content or you do not have permission!');
        }
    }
    public function getDocuments(Request $request) {
        //Get by id
        if ($request->id != '') {
            $document = Content::where('type', 'not like', 'video')->where('id', $request->id)->where('system', activeGuard())->where('created_by', Auth::guard(activeGuard())->user()->id)->first();
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
        $documents->where('type', 'not like', 'video')->where('system', activeGuard())->where('created_by', Auth::guard(activeGuard())->user()->id);
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

        return view(activeGuard().'.informations.content-management.documents', compact('documents', 'status', 'keyword','count','order'));
    }

    public function postDocument(Request $request) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'intro' => 'required',
            'action' => 'required',
            'attachment' => ($request->action == 'add') ? ['required', File::types(['doc', 'docx', 'pdf'])->max('2gb')] : '',
        ],[
            'intro.required' => 'The content introduction field is required.'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if ($request->action == 'add') {
            $document = new Content();
        }elseif ($request->action == 'edit') {
            $document = Content::where('type','not like', 'video')->where('created_by', Auth::guard(activeGuard())->user()->id)->where('id', $request->id)->where('system', activeGuard())->first();
            if (!$document) {
                return redirect()->route(activeGuard().'.informations.content-management.documents')->withErrors('Can not find this content or you do not have permission!');
            }
        }
        $document->title = $request->title;
        $document->slug = \Str::slug($request->title);
        $document->intro = $request->intro;
        $document->status = 0;
        $document->author = $request->author;
        $document->license = $request->license;
        if ($request->has('attachment')) {
            $file = $request->file('attachment');
            $mimeType = $file->getMimeType();
            switch ($mimeType) {
                case 'application/msword':
                    $fileType = 'doc';
                    break;
                case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                    $fileType = 'docx';
                    break;
                case 'application/pdf':
                    $fileType = 'pdf';
                    break;
                default:
                    $fileType = 'Unknown';
            }

            $document->type = $fileType;
            $document->size = number_format($request->file('attachment')->getSize() / 1048576,2)." MB";
            $fullName = $file->getClientOriginalName();
            $storage_path = storage_path('app/public'.activeGuard().'content-management/documents'.Auth::guard(activeGuard())->user()->id.'/');
            $file->move($storage_path, $fullName);
            $path = activeGuard().'content-management/documents'.Auth::guard(activeGuard())->user()->id.'/'.$fullName;
            $document->attachment_details = json_encode([
                'filename' => $fullName,
                'path' => $path,
                'size' => $document->size
            ]);

        }

        $document->system = activeGuard();
        $document->created_by = Auth::guard(activeGuard())->user()->id;
        if ($document->save()) {
            return redirect()->route(activeGuard().'.informations.content-management.documents')->with('success', 'SAVED!');
        }
    }

    public function downloadDocument($id) {
        $document = Content::where('id', $id)->first();
        if ($document) {
            $attachment_details = json_decode($document->attachment_details);
            if (isset($attachment_details->path)) {
                $path = storage_path().'/'.'app/'.$attachment_details->path;
                return response()->download($path);
            }
        }
        return redirect()->route(activeGuard().'.informations.content-management.documents')->withErrors('Can not find this content!');
    }
}
