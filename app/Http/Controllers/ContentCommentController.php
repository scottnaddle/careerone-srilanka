<?php

namespace App\Http\Controllers;

use App\Http\Requests\QnaAnswerRequest;
use App\Models\QNA;
use App\Models\QNAAnswer;
use App\Models\Resource;
use App\Services\Cgo\NotificationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContentComment;
use App\Models\Content;

class ContentCommentController extends Controller
{
    protected $notificationManager;

    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }


    /**
     * Store a newly created resource in storage.
     */
//    public function store(QnaAnswerRequest $request)
//        {
//            $data = $request->all();
//            $data['content_id'] = $data['qna_id'];
//            $activeGuard = Auth::guard(activeGuard());
//
//            if ($activeGuard->check()) {
//                $data['answer_by'] = $activeGuard->user()->id;
//            }
//
//            if ($data['system'] == 'admin') {
//                $data['answer_by'] = Auth::guard('admin')->user()->id;
//            }
//
//            $data['parent_id'] = $data['parent_id'] ?? null;
//            $data['type'] = $data['type'] ?? 'content';
//
//            $contentCommentAnswer = ContentComment::create($data);
//            $userReplyName = !empty($activeGuard->user()->fullName)  ? $activeGuard->user()->fullName :
//                ($activeGuard->user()->first_name ?? '') . ' ' . ($activeGuard->user()->last_name ?? '');
//
//            $userReplyName = trim($userReplyName) ?: '';
//            if ($data['parent_id']) {
//                $commentParent = ContentComment::where('id', $data['parent_id'])
//                    ->where('type', $data['type'])
//                    ->first();
//
//                if ($commentParent) {
//                    $authorCommentParentId = $commentParent->author->id;
//
//                    if ($authorCommentParentId !== $data['answer_by'] || $commentParent->system != $data['system']) {
//                        if ($data['type'] == 'content') {
//                            $this->notificationManager->SendNotificationReplyContent($commentParent,$userReplyName);
//                        }else {
//                            $this->notificationManager->SendNotificationReplyResource($commentParent,$userReplyName);
//                        }
//                    }
//                }
//            } else {
//                // Notify if it's a reply to the main QNA
//                if ($data['type'] == 'resource') {
//                    $qNA = Resource::with('author')->find($contentCommentAnswer->content_id);
//                }else {
//                    $qNA = Content::with('author')->find($contentCommentAnswer->content_id);
//                }
//
//                if ($qNA) {
//                    if ($data['answer_by'] != $qNA->created_by || $qNA->system != $data['system']) {
//
//                        if ($data['type'] == 'content') {
//                            $this->notificationManager->SendNotificationReplyContent($qNA,$userReplyName);
//                        }else {
//                            $this->notificationManager->SendNotificationReplyResource($qNA,$userReplyName);
//                        }
//
//                    }
//                }
//            }
//
//            $canEdit = activeGuard() ? (Auth::guard(activeGuard())->check() && Auth::guard(activeGuard())->user()->id === $data['answer_by'] && $data['system'] === activeGuard()) : Auth::guard('admin')->check() && Auth::guard('admin')->user()->id === $data['answer_by'] && $data['system'] === 'admin';
//
//            // Return a success response with the newly created reply data
//            return response()->json([
//                'status' => 'success',
//                'code' => 200,
//                'message' => 'Reply sent successfully!',
//                'data' => [
//                    'qna_id' => $contentCommentAnswer->content_id ?? -1,
//                    'id' => $contentCommentAnswer->id,
//                    'answer' => $contentCommentAnswer->answer,
//                    'created_at' => $contentCommentAnswer->created_at->toDateTimeString(),
//                    'author' => [
//                        'id' => $contentCommentAnswer->author->id,
//                        'fullName' => $contentCommentAnswer->author->fullName,
//                        'profile_image' => $contentCommentAnswer->author->profile_image,
//                    ],
//                    'parent_id' => $contentCommentAnswer->parent_id ?? null,
//                    'answer_by' => $data['answer_by'],
//                    'system' => activeGuard() ?? 'admin',
//                    'canEdit' => $canEdit,
//                    'type' => $data['type']
//                ]
//            ]);
//        }
    public function store(QnaAnswerRequest $request)
    {
        $data = $request->all();
        $data['content_id'] = $data['qna_id'];
        $data['parent_id'] = $data['parent_id'] ?? null;
        $data['type'] = $data['type'] ?? 'content';

        $guard = $data['system'] === 'admin' ? Auth::guard('admin') : Auth::guard(activeGuard());
        if ($guard->check()) {
            $data['answer_by'] = $guard->user()->id;
        }

        $contentCommentAnswer = ContentComment::create($data);
        $contentCommentAnswer->load('author');

        $user = $guard->user();
        $userReplyName = $user->fullName ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));

        if ($data['parent_id']) {
            $commentParent = ContentComment::with('author')->find($data['parent_id']);
            if ($commentParent &&
                ($commentParent->author->id !== $data['answer_by'] || $commentParent->system != $data['system'])
            ) {
                if ($data['type'] === 'content') {
                    $this->notificationManager->SendNotificationReplyContent($commentParent, $userReplyName);
                } elseif ($data['type'] === 'resource') {
                    $this->notificationManager->SendNotificationReplyResource($commentParent, $userReplyName);
                }
            }
        } else {
            $qNA = $data['type'] === 'resource'
                ? Resource::with('author')->find($data['qna_id'])
                : Content::with('author')->find($data['qna_id']);

            if ($qNA && ($data['answer_by'] != $qNA->created_by || $qNA->system != $data['system'])) {
                if ($data['type'] === 'content') {
                    $this->notificationManager->SendNotificationReplyContent($qNA, $userReplyName);
                } elseif ($data['type'] === 'resource') {
                    $this->notificationManager->SendNotificationReplyResource($qNA, $userReplyName);
                }
            }
        }

        $canEdit = $guard->check() && $guard->user()->id === $data['answer_by'] && $data['system'] === ($data['system'] ?? activeGuard());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Reply sent successfully!',
            'data' => [
                'qna_id' => $contentCommentAnswer->content_id ?? -1,
                'id' => $contentCommentAnswer->id,
                'answer' => $contentCommentAnswer->answer,
                'created_at' => $contentCommentAnswer->created_at->toDateTimeString(),
                'author' => [
                    'id' => $contentCommentAnswer->author->id,
                    'fullName' => $contentCommentAnswer->author->fullName,
                    'profile_image' => $contentCommentAnswer->author->profile_image,
                ],
                'parent_id' => $contentCommentAnswer->parent_id ?? null,
                'answer_by' => $data['answer_by'],
                'system' => $data['system'],
                'canEdit' => $canEdit,
                'type' => $data['type']
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($contentCommentId)
    {
        $contentCommentAnswer = ContentComment::find($contentCommentId);
        if ($contentCommentAnswer) {
            foreach ($contentCommentAnswer->children as $reply) {
                $reply->delete();
            }

            $contentCommentAnswer->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Reply not found'], 404);
        }
    }


    public function like($id, $type = 'content')
    {
        if ($type == 'content') {
            $content = Content::findOrFail($id);
        }else {
            $content = Resource::findOrFail($id);
        }
        if ($content) {
            $content->likes += 1;
            $content->save();

            return response()->json([
                'success' => true,
                'likes' => $content->likes,
            ]);
        }
    }
}
