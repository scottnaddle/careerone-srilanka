<?php

namespace App\Http\Controllers;

use App\Http\Requests\QNARequest;
use App\Http\Requests\QNAUpdateRequest;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\QNA;
use App\Models\QnaAttachment;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class QNAController extends Controller
{
    public function __construct() {
        $this->middleware('user.auth')->except(['index','destroy', 'downloadDocument', 'show', '']);
    }

    /**
     * Get qna author
     */

    public function getAuthorQNA($system, $id)
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize the query
        $query = QNA::query();

        // Filter by title if provided
        if ($request->has('title') && $request->query('title') !== '') {
            $query->where('title', 'ILIKE', '%' . $request->query('title') . '%');
        }

        // Filter by qna type if provided
        if ($request->has('qna_type') && $request->query('qna_type') != '') {
            if ($request->query('qna_type') == 'recently') {
                // Sort by created date descending
                $query->orderBy('created_at', 'desc');
            } else {
                // For other qna_type values, sort by created date ascending
                $query->orderBy('created_at', 'asc');
            }
        } else {
            // Default to sorting by created date descending
            $query->orderBy('created_at', 'desc');
        }
        // Paginate the results
        $qnas = $query->paginate(10);

        // Add author information and reply count to each item
        foreach ($qnas as $item) {
            $user = $this->getAuthorQNA($item->system, $item->created_by);
            $item->author = $user;
            $item->numberOfReplies = $item->replies->count();

            foreach ($item->replies as $childReply) {
                $item->numberOfReplies += $childReply->children->count();
            }
        }

        // Append the query parameters to the pagination links
        $qnas->appends($request->all());

        // Return the view with the data
        return view('informations.qnas.qna')->with(['qnas' => $qnas]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(QNARequest $request)
    {
        $data = $request->all();
        $data['status'] = 0;
        $data['system'] = activeGuard();
        $data['slug'] =  $this->generateUniqueSlug($data['title'], QNA::class);;
        $data['created_by'] = Auth::guard(activeGuard())->user()->id;
        $qna = QNA::create($data);

        if ($request->has('attachment_details')) {
            foreach ($request->file('attachment_details') as $attachment) {
                $mimeType = $attachment->getMimeType();
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
                    case 'image/png':
                        $fileType = 'image';
                        break;
                    case 'image/jpg':
                        $fileType = 'image';
                        break;
                    case 'image/jpeg':
                        $fileType = 'image';
                        break;
                    default:
                        $fileType = 'Unknown';
                }
                $storage_path = storage_path('app/public/' . activeGuard() . '/qnas/attachment_details/' . $qna->id);
                $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $fileNameToStore = \Illuminate\Support\Str::uuid() . '.' . strtolower($extension);
                $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
                $attachment->move($storage_path, $fileNameToStore);
                $path = 'storage/' . activeGuard() . '/qnas/attachment_details/' . $qna->id . '/' . $fileNameToStore;
                $qnaAttachment = new QnaAttachment();
                $qnaAttachment->qna_id = $qna->id;
                $qnaAttachment->file_name = $filename;
                $qnaAttachment->path = $path;
                $qnaAttachment->file_type = $fileType;
                $qnaAttachment->file_size = $fileSize;
                $qnaAttachment->save();
            }
        }


        return redirect()->route('informations.qnas.list')->with('success', 'Create Q&A succesfully');
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
     * Display the specified resource.
     */
    public function show($slug)
    {
        $qna = QNA::where('slug', $slug)->first();
        if ($qna) {
            $user = $this->getAuthorQNA($qna->system, $qna->created_by);
            $qna->author = $user;
            foreach ($qna->replies as $item) {
                $user = $this->getAuthorQNA($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorQNA($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }
//             dd($qna);
            return view('informations.qnas.reply', compact('qna'));
        }else {
            return redirect()->route('informations.qnas.list')->withErrors('Can not find Q&A!');
        }

    }

    public function getUpdate($slug) {
        $qna = QNA::where('slug', $slug)->first();
        if ($qna) {
            $user = $this->getAuthorQNA($qna->system, $qna->created_by);
            $qna->author = $user;
            foreach ($qna->replies as $item) {
                $user = $this->getAuthorQNA($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorQNA($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }
//             dd($qna);
            return view('informations.qnas.edit', compact('qna'));
        }else {
            return redirect()->route('informations.qnas.list')->withErrors('Can not find Q&A!');
        }
    }

    public function downloadDocument($id)
    {
        $document = QnaAttachment::where('id', $id)->first();
        if ($document) {
            if (isset($document->path)) {
                $path = $document->path;
                return response()->download($path);
            }
        }
        return redirect()->route('informations.qnas.list')->withErrors('Can not find this content!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QNAUpdateRequest $request, QNA $qNA)
    {
        if ($request->has('attachment_details')) {
            foreach ($request->file('attachment_details') as $attachment) {
                $mimeType = $attachment->getMimeType();
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
                    case 'image/png':
                        $fileType = 'image';
                        break;
                    case 'image/jpg':
                        $fileType = 'image';
                        break;
                    case 'image/jpeg':
                        $fileType = 'image';
                        break;
                    default:
                        $fileType = 'Unknown';
                }
                $storage_path = storage_path('app/public/' . activeGuard() . '/qnas/attachment_details/' . $qNA->id);
                $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $fileNameToStore = \Illuminate\Support\Str::uuid() . '.' . strtolower($extension);
                $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
                $attachment->move($storage_path, $fileNameToStore);
                $path = 'storage/' . activeGuard() . '/qnas/attachment_details/' . $qNA->id . '/' . $fileNameToStore;
                $qnaAttachment = new QnaAttachment();
                $qnaAttachment->qna_id = $qNA->id;
                $qnaAttachment->file_name = $filename;
                $qnaAttachment->path = $path;
                $qnaAttachment->file_type = $fileType;
                $qnaAttachment->file_size = $fileSize;
                $qnaAttachment->save();
            }
        }
        $data = $request->all();
//        $data['slug'] = Str::slug($data['title'], '-', 'ta');
        // if ($data['slug']) dd(1);
        // dd($request->all());
        $qNA->update($data);

        return redirect()->route('informations.qnas.reply', ['slug' => $qNA->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $qNA = QNA::where('id', $id)->first();
        foreach ($qNA->replies as $reply) {
            foreach ($reply->children as $childReply) {
                $childReply->delete();
            }
            $reply->delete();
        }

        foreach ($qNA->attachments as $attachment) {
            if (file_exists($attachment->path)) {
                @unlink($attachment->path);
            }
            $attachment->delete();
        }
        $folder = 'storage/' . activeGuard() . '/qnas/attachment_details/' . $id;
        if (File::exists($folder)) File::deleteDirectory($folder);

        $qNA->delete();



        return redirect()->route('informations.qnas.list')->with('success', 'Delete successfully');
    }
}
