<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Http\Requests\EventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\CategorySystem;
use App\Models\Event;
use App\Models\EventAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.auth')->except(['downloadDocument', 'show', 'searchByFilter', 'getPublicEvent']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::guard('trainee')->check() || activeGuard() == '') {
            return redirect('/public-event');
        }
        $today = Carbon::today()->toDateString();
        // Kiểm tra xem người dùng đã đăng nhập chưa
        $isSignedIn = Auth::guard(activeGuard())->check();
        $status = $request->has('status') ? $request->status : 'all';
        // Bắt đầu xây dựng truy vấn cho các sự kiện, sắp xếp theo created_at giảm dần
        $query = Event::query();
        if ($isSignedIn) {
            $user = Auth::guard(activeGuard())->user();

            $query->where(function ($subQuery) use ($user) {
                $subQuery->where(function ($createdByQuery) use ($user) {
                    $createdByQuery->where('created_by', $user->id)
                        ->where('system', activeGuard());
                })
                ->orWhere(function ($approvedQuery) {
                    $approvedQuery->where('status', 2)
                        ->where('system', Constant::cgo);
                });
    });
        } else {
            $query->where('status', \App\Enums\StatusEnumsManagement::APPROVED->value);
        }

        // Áp dụng bộ lọc theo tiêu đề nếu tham số 'title' có trong truy vấn và không rỗng
        if ($request->has('title') && $request->query('title') !== '') {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->has('type') && $request->query('type') !== '' && $request->query('type') !== 'all') {
            $query->where('event_type',  $request->query('type'));
        }
        if ($request->has('status') && $request->query('status') !== '' && $request->query('status') !== 'all') {
            $query->where('status',  $request->query('status'));
        }
        if ($request->has('sort_by') && $request->query('sort_by') == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Phân trang kết quả
        $events = $query->paginate(8);

        // Thêm các tham số truy vấn vào các liên kết phân trang
        $events->appends($request->all());

        // Trả về view với dữ liệu sự kiện
        return view('informations.events.event')->with(['events' => $events, 'status' => $status]);
    }
    public function getListEventType()
    {
        $language = app()->getLocale();
        $moduleColumn = match ($language) {
            'en' => 'code_name_en',
            'tm' => 'code_name_tm',
            'sn' => 'code_name_sn',
            default => 'code_name_en',
        };

        return CategorySystem::where('module', 'event')
            ->select('id', \DB::raw("$moduleColumn as name"))
            ->get();
    }

    public function getPublicEvent(Request $request)
    {

        // Bắt đầu xây dựng truy vấn cho các sự kiện, sắp xếp theo created_at giảm dần
        $query = Event::query();

        $query->where('status', \App\Enums\StatusEnumsManagement::APPROVED->value);

        // Áp dụng bộ lọc theo tiêu đề nếu tham số 'title' có trong truy vấn và không rỗng
        if ($request->has('title') && $request->query('title') !== '') {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        if ($request->has('event_type') && $request->query('event_type') !== 'all') {
            $query->where('event_type', $request->query('event_type'));
        }

        $sortBy = $request->query('sort_by', 'recently');

        if ($sortBy === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }


        // Phân trang kết quả
        $events = $query->paginate(8);
        $event_types = $this->getListEventType();
        // Thêm các tham số truy vấn vào các liên kết phân trang
        $events->appends($request->all());

        // Trả về view với dữ liệu sự kiện
        return view('informations.events.public-event')->with(['event_types' => $event_types, 'events' => $events]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listEventType = $this->getListEventType();
        return view('informations.events.create', compact(var_name: 'listEventType'));
    }

    public function downloadDocument($id)
    {
        $document = EventAttachment::find($id);
        if ($document && isset($document->path)) {
            $path = $document->path;
            if (\Storage::disk('public')->exists($path)) {
                return response()->download(storage_path('app/public/' . $path));
            } else {
                \Log::warning('File not found at path: ' . $path);
                return redirect()->back()->withErrors(trans('system.information.event.not_found'));
            }
        }

        return redirect()->back()->withErrors(trans('system.information.event.not_found'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
{
    $data = $request->all();
    $data['slug'] = $this->generateUniqueSlug($data['title'], Event::class);
    $data['start_time'] = Carbon::parse($data['start_time'])->format('Y-m-d');
    $data['end_time'] = Carbon::parse($data['end_time'])->format('Y-m-d');
    $data['system'] = activeGuard();
    $data['thumbnail'] = '';
    $data['created_by'] = Auth::guard(activeGuard())->id();
    $data['status'] = \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value;

    $event = Event::create($data);

    // Handle Thumbnail Upload
    if ($request->hasFile('thumbnail')) {
        $thumbnail = $request->file('thumbnail');
        $path = saveImageAsWebp($thumbnail, 'events/thumbnails/' . $event->id);
        $event->update(['thumbnail' => $path]);
    }

    // Handle Attachments
    if ($request->hasFile('attachment_details') && is_array($request->file('attachment_details'))) {
        foreach ($request->file('attachment_details') as $attachment) {
            $mimeType = $attachment->getMimeType();
            $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $attachment->getClientOriginalExtension();
            $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
            $directory = 'events/attachment_details/' . $event->id;

            // Determine file type
            $fileType = match ($mimeType) {
                'image/jpeg', 'image/png', 'image/jpg' => 'image',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/pdf' => 'pdf',
                default => 'unknown',
            };

            if ($fileType === 'image') {
                $filePath = saveImageAsWebp($attachment, $directory, $filename);
            } else {
                $fileNameToStore = $filename . '.' . $extension;
                $relativePath = $directory . '/' . $fileNameToStore;
                $attachment->storeAs('public/' . $directory, $fileNameToStore);
                $filePath = 'storage/' . $relativePath;
            }

            EventAttachment::create([
                'event_id' => $event->id,
                'file_name' => $filename,
                'path' => $filePath,
                'file_type' => $fileType,
                'file_size' => $fileSize,
            ]);
        }
    }

    return redirect()->route('informations.events.event')->with('success', trans('system.information.event.created'));
}

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->first();

        return view('informations.events.detail', compact('event'));
    }
    function generateUniqueSlug($title, $model, $column = 'slug')
    {
        $slug = Str::slug($title, '-', 'ta');
        $counter = 2;
        while ($model::where($column, $slug)->exists()) {
            $slug = Str::slug($title, '-', 'ta') . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if($event->system==activeGuard()
        && $event->created_by==Auth::guard(activeGuard())->user()->id
        && $event->status!=2
        ){
        $listEventType = $this->getListEventType();
        return view('informations.events.edit')->with(['event' => $event, 'listEventType' => $listEventType]);
        }else{
            return redirect()->route('informations.events.event')->withErrors(trans('system.information.event.not_found'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
{
    if (
        $event->system == activeGuard() &&
        $event->created_by == Auth::guard(activeGuard())->user()->id &&
        $event->status != 2
    ) {
        $data = $request->all();
        $data['slug'] = $this->generateUniqueSlug($data['title'], Event::class);
        $data['start_time'] = Carbon::parse($data['start_time'])->format('Y-m-d');
        $data['end_time'] = Carbon::parse($data['end_time'])->format('Y-m-d');
        $data['system'] = activeGuard();
        $data['status'] = \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value;
        $data['created_by'] = Auth::guard(activeGuard())->user()->id;

        // Thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->storeThumbnail($request->file('thumbnail'), $event->id);
        }

        $event->update($data);

        // Attachments
        if ($request->hasFile('attachment_details')) {
            foreach ($request->file('attachment_details') as $attachment) {
                $this->storeAttachment($attachment, $event->id);
            }
        }

        return redirect()->route('informations.events.event')->with('success', trans('system.information.event.updated'));
    }

    return redirect()->route('informations.events.event')->withErrors(trans('system.information.event.not_found'));
}
private function storeThumbnail($thumbnail, $eventId)
{
    $storagePath = storage_path('app/public/' . activeGuard() . '/events/thumbnails/' . $eventId);
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    $filename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
    $fileNameToStore = $filename . '.webp';

    \Intervention\Image\Facades\Image::make($thumbnail)
        ->encode('webp', 80)
        ->save($storagePath . '/' . $fileNameToStore);

    return 'storage/' . activeGuard() . '/events/thumbnails/' . $eventId . '/' . $fileNameToStore;
}

private function storeAttachment($attachment, $eventId)
{
    $mimeType = $attachment->getMimeType();
    $fileType = match ($mimeType) {
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/pdf' => 'pdf',
        'image/jpeg', 'image/jpg', 'image/png' => 'image',
        default => 'unknown',
    };

    $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = $attachment->getClientOriginalExtension();
    $fileNameToStore = $fileType === 'image' ? ($filename . '.webp') : ($filename . '.' . $extension);

    $storagePath = storage_path('app/public/' . activeGuard() . '/events/attachment_details/' . $eventId);
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    if ($fileType === 'image') {
        \Intervention\Image\Facades\Image::make($attachment)
            ->encode('webp', 80)
            ->save($storagePath . '/' . $fileNameToStore);
    } else {
        $attachment->move($storagePath, $fileNameToStore);
    }

    $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
    $path = 'storage/' . activeGuard() . '/events/attachment_details/' . $eventId . '/' . $fileNameToStore;

    EventAttachment::create([
        'event_id' => $eventId,
        'file_name' => $filename,
        'path' => $path,
        'file_type' => $fileType,
        'file_size' => $fileSize,
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event) {
            if (file_exists($event->thumbnail)) {
                @unlink($event->thumbnail);
            }
            $folderThumb = 'storage/' . activeGuard() . '/events/thumbnails/' . $id;
            if (File::exists($folderThumb)) File::deleteDirectory($folderThumb);
            foreach ($event->attachments as $attachment) {
                if (file_exists($attachment->path)) {
                    @unlink($attachment->path);
                }
                $attachment->delete();
            }
            $folder = 'storage/' . activeGuard() . '/events/attachment_details/' . $id;
            if (File::exists($folder)) File::deleteDirectory($folder);
            $event->delete();
            return redirect()->back()->with('success', 'Delete successfully!');
        }
        return redirect()->back()->withErrors(trans('system.information.event.not_found'));
    }

    public function searchByFilter(Request $request)
    {
        // $searchType = $request->searchType;
        $searchText = $request->searchText;
        $param = 'title';
        // switch($searchType){
        //     case 'type':
        //         $param = 'event_type';
        //         break;
        //     case 'status':
        //         $param = 'status';
        //         break;
        //     case 'title':
        //         $param = 'title';
        //         break;
        // }

        $events = [];
        if (!$searchText) {
            $events = Event::paginate(10);
        } else {
            $events = Event::where($param, 'LIKE', "%{$searchText}%")->paginate(10);
        }
        return view('informations.events.event')->with(['events' => $events]);
    }
}
