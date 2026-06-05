<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Enums\NoticeTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\QnaAnswerRequest;
use App\Http\Requests\QNARequest;
use App\Http\Requests\QNAUpdateRequest;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\QNA;
use App\Models\QNAAnswer;
use App\Models\QnaAttachment;
use App\Models\TraineeUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Faq;
use App\Models\FaqArticle;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Services\Cgo\NotificationManager;

class InformationController extends BaseController
{

    protected $notificationManager;

    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    public function getEvents(Request $request): JsonResponse
    {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $id = $request->has('id') ? $request->id : '';
        $orderBy = $request->has('sort_by') ? $request->sort_by : 'desc';
        $event_type = $request->has('event_type') ? $request->event_type : '';
        $isAdminEvent = $request->has('system') ? $request->query('system') : '';

        $events = Event::query();

        if ($id) {
            $event = $events->where('id', $id)->first();
            if ($event) {
                $event->load(['attachments']);
                $event->thumbnail = asset($event->thumbnail);
                $event->short_description = mb_convert_encoding(substr(strip_tags($event->details), 0, 180), 'UTF-8', 'auto');
                $event->short_description = preg_replace('/data:image\/[a-zA-Z]*;base64,[^\"]*/', '', $event->short_description);
                if (mb_strlen($event->details) > 200) {
                    $event->short_description .= "...";
                }
                if ($event->attachments->count() > 0) {
                    foreach ($event->attachments as $attachment) {
                        $attachment->path = asset($attachment->path);
                    }
                }
//                $event->event_type = getCodeNameByCodeId('event_type', $event->event_type, $request->lang ? $request->lang : null);
                $event->author = $event->author->fullName;
                $data['data'] = $event;
                return $this->sendResponse($data, ['message', 'Event data retrieved successfully!']);
            }
        }

        if ($keyword) {
            $events->where('title', 'ILIKE', '%' . $keyword . '%');
        }
        if ($orderBy) {
            $events->orderBy('created_at', $orderBy);
        }

        if ($event_type) {
            $events->where('event_type', $event_type);
        }

        if ($isAdminEvent) {
            $events->where('system', 'admin');
        }

        $events->where('status', 2);
        $total = $events->count();
        $events = $events->paginate(10);

        foreach ($events as $event) {
            $event->load(['attachments']);
            $event->thumbnail = asset($event->thumbnail);
            $event->short_description = mb_convert_encoding(substr(strip_tags($event->details), 0, 180), 'UTF-8', 'auto');
            $event->short_description = preg_replace('/data:image\/[a-zA-Z]*;base64,[^\"]*/', '', $event->short_description);
            if (mb_strlen($event->details) > 200) {
                $event->short_description .= "...";
            }
            if ($event->attachments->count() > 0) {
                foreach ($event->attachments as $attachment) {
                    $attachment->path = asset($attachment->path);
                }
            }
            $event->id_type=$event->event_type;
//            $event->event_type = getCodeNameByCodeId('event_type', $event->event_type, $request->lang ? $request->lang : null);
            $event->author = $event->author->fullName;
        }

        $data['total'] = $total;
        $data['data'] = $events;
        return $this->sendResponse($data, ['message', 'Event data retrieved successfully!']);
    }


    public function getAllQNA(Request $request): JsonResponse
    {
        $key_word = $request->has('key_word') ? $request->query('key_word') : '';
        $sort_by = $request->has('sort_by') ? $request->query('sort_by') : 'desc';
        $qnas = QNA::query();

        $qnas->orderBy('created_at', $sort_by);

        if ($key_word)
            $qnas->where('title', 'ILIKE', '%' . $key_word . '%');

        $qnas = $qnas->paginate(10);
        $total = $qnas->count();
        foreach ($qnas as $item) {
            $user = $this->getAuthorQNA($item->system, $item->created_by);
            $item->author = $user;
            $item->numberOfReplies = $item->replies->count();

            foreach ($item->replies as $childReply) {
                $item->numberOfReplies += $childReply->children->count();
            }
        }
        $data['total'] = $total;
        $data['data'] = $qnas;
        return $this->sendResponse($data, ['message', 'QNA datas retrive successfull!']);
    }

    public function getQNA(Request $request): JsonResponse
    {
        $qna = QNA::where('id', $request->id)->with('attachments')->first();
        if ($qna) {
            $user = $this->getAuthorQNA($qna->system, $qna->created_by);
            $qna->author = $user;
            foreach ($qna->replies as $item) {
                $user = $this->getAuthorQNA($item->system, $item->answer_by);
                $item->user_reply_informations = $user;
                $item->user_reply_informations->profile_image = $user->profile_image ? asset($user->profile_image) : '';
                $item->user_reply_informations->fullname = $user->fullName;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorQNA($child->system, $child->answer_by);
                    $child->user_reply_informations = $childUser;
                    $child->user_reply_informations->profile_image = $childUser->profile_image ? asset($childUser->profile_image) : '';
                    $child->user_reply_informations->fullname = $childUser->fullName;
                }
            }
            if ($qna->attachments->count() > 0) {
                foreach ($qna->attachments as $attachment) {
                    $attachment->path = asset($attachment->path);
                }
            }
            $data['data'] = $qna;
            return $this->sendResponse($data, ['message', 'QNA datas retrive successfull!']);
        } else {
            return $this->sendError('Error', ['message', 'Not found Q&A!']);
        }
    }

    public function answerQNA(QnaAnswerRequest $request)
    {
        $item = $request->all();
        $userNameReply='';
        if (auth('sanctum')->check()) {
            $item['answer_by'] = auth('sanctum')->user()->id;
            $userNameReply=!empty(auth('sanctum')->user()->fullName) ? auth('sanctum')->user()->fullName  : auth('sanctum')->user()->first_name.' '.auth('sanctum')->user()->last_name;

        }

        $item['parent_id'] = $item['parent_id'] ?? null;
        $item['system'] = 'trainee';

        $qNAAnswer = QNAAnswer::create($item);
        if ($qNAAnswer) {
            $data['data'] = $qNAAnswer;
            if ($item['parent_id']) {
                $commentParent = QNAAnswer::find($item['parent_id']);

                if ($commentParent) {
                    $authorCommentParentId = $commentParent->author->id;

                    if ($authorCommentParentId !== $item['answer_by'] || $commentParent->system != $item['system']) {
                        $this->notificationManager->SendNotificationReply($commentParent,$userNameReply);
                    }
                }
            } else {
                $qNA = QNA::with('author')->find($qNAAnswer->qna_id);
                if ($qNA) {
                    if ($item['answer_by'] != $qNA->created_by || $qNA->system != $item['system']) {
                        $this->notificationManager->SendNotificationReply($qNA,$userNameReply);
                    }
                }
            }
            return $this->sendResponse($data, ['message', 'Answer successfull!']);
        }


        return $this->sendError('Error', ['message', 'Can not answer Q&A!']);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeQNA(Request $request)
    {
        $item = $request->all();
        $item['status'] = 0;
        $item['system'] = 'trainee';
        $item['slug'] =  Str::slug($item['title'], '-', 'ta');
        $item['created_by'] = auth('sanctum')->user()->id;
        $qna = QNA::create($item);

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
                $fileNameToStore = $filename . '.' . $extension;
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
        $data['data'] = $qna;
        return $this->sendResponse($data, ['message', 'Create new QNA successfull!']);
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
        }
        return $user;
    }

    public function getNotices(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword', '');
        $notice_type = $request->query('notice_type', '');

        $noticeQuery = Notice::query();
        $noticeQuery->orderBy('created_at', 'desc');

        if (!empty($keyword)) {
            $noticeQuery->where('title', 'ILIKE', '%' . $keyword . '%');
        }


        if (!empty($notice_type)) {
            $noticeQuery->where('type', $notice_type);
        }

        $notices = $noticeQuery->paginate(10)->appends($request->query());
        foreach ($notices as $notice) {
            $notice->id_type = $notice->type;
//            $notice->type = getCodeNameByCodeId('notice_type', $notice->type, $request->lang ? $request->lang : null);
            $notice->full_name = $notice->author->fullName;

        }
        $data = [
            'total' => $notices->total(),
            'data' => $notices
        ];

        // Use the correct response method (assuming `sendResponse` is defined in your base controller)
        return $this->sendResponse($data, 'Retrieve notices successfully!');
    }


    public function getNoticeById($id): JsonResponse
    {
        $notice = Notice::find($id);

        $data['data'] = $notice;

        return $this->sendResponse($data, ['message', 'Retrive notice successfully!']);
    }

    public function getFaqs(Request $request): JsonResponse
    {
        $faqs = Faq::with(['faqArticle'])->paginate(10);

        $data['total'] = $faqs->total();
        $data['data'] = $faqs;

        return $this->sendResponse($data, ['message', 'Retrive faqs successfully!']);
    }

    public function destroyQNA($id){
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
        $folder = 'storage/trainee/qnas/attachment_details/' . $id;
        if (File::exists($folder)) File::deleteDirectory($folder);

        $qNA->delete();

        return $this->sendResponse([], ['Delete QNA successfully!']);
    }

    public function destroyQNAComment(QNAAnswer $qNAAnswer)
    {
        if ($qNAAnswer) {
            foreach ($qNAAnswer->children as $reply) {
                $reply->delete();
            }

            $qNAAnswer->delete();
            return $this->sendResponse([], ['Delete QNA Comment successfully!']);
        } else {
            return $this->sendError([], ['Reply not found!']);
        }
    }

    public function updateQNA(QNAUpdateRequest $request, $id)
    {
        $qNA = QNA::find($id);
        if ($qNA) {
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
                    $storage_path = storage_path('app/public/trainee/qnas/attachment_details/' . $qNA->id);
                    $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $attachment->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
                    $attachment->move($storage_path, $fileNameToStore);
                    $path = 'storage/trainee/qnas/attachment_details/' . $qNA->id . '/' . $fileNameToStore;
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
            $qNA->update($data);
            return $this->sendResponse($qNA, ['Update QNA successfully!']);
        }else {
            return $this->sendError([], 'QNA does not exist!');
        }

    }
}
