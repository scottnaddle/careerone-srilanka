<?php

namespace App\Http\Controllers;

use App\Http\Requests\QnaAnswerRequest;
use App\Models\QNAAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CgoUser;
use App\Services\Cgo\NotificationManager;
use App\Models\QNA;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Validator;

class QNAAnswerController extends Controller
{

    protected $notificationManager;

    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(QnaAnswerRequest $request)
    {
        $data = $request->all();
        $activeGuard = Auth::guard(activeGuard());

        if ($activeGuard->check()) {
            $data['answer_by'] = $activeGuard->user()->id;
        }

        if ($data['system'] == 'admin') {
            $data['answer_by'] = Auth::guard('admin')->user()->id;
        }

        $data['parent_id'] = $data['parent_id'] ?? null;

        $qNAAnswer = QNAAnswer::create($data);
        $userReplyName = !empty($activeGuard->user()->fullName)  ? $activeGuard->user()->fullName :
         ($activeGuard->user()->first_name ?? '') . ' ' . ($activeGuard->user()->last_name ?? '');
    
    $userReplyName = trim($userReplyName) ?: '';
        if ($data['parent_id']) {
            $commentParent = QNAAnswer::find($data['parent_id']);

            if ($commentParent) {
                $authorCommentParentId = $commentParent->author->id;

                if ($authorCommentParentId !== $data['answer_by'] || $commentParent->system != $data['system']) {
                    $this->notificationManager->SendNotificationReply($commentParent,$userReplyName);
                }
            }
        } else {
            // Notify if it's a reply to the main QNA
            $qNA = QNA::with('author')->find($qNAAnswer->qna_id);
            if ($qNA) {
                if ($data['answer_by'] != $qNA->created_by || $qNA->system != $data['system']) {
                    $this->notificationManager->SendNotificationReply($qNA,$userReplyName);
                }
            }
        }

        $canEdit = activeGuard() ? (Auth::guard(activeGuard())->check() && Auth::guard(activeGuard())->user()->id === $data['answer_by'] && $data['system'] === activeGuard()) : Auth::guard('admin')->check() && Auth::guard('admin')->user()->id === $data['answer_by'] && $data['system'] === 'admin';

        // Return a success response with the newly created reply data
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Reply sent successfully!',
            'data' => [
                'qna_id' => $qNAAnswer->qna_id ?? -1,
                'id' => $qNAAnswer->id,
                'answer' => $qNAAnswer->answer,
                'created_at' => $qNAAnswer->created_at->toDateTimeString(),
                'author' => [
                    'id' => $qNAAnswer->author->id,
                    'fullName' => $qNAAnswer->author->fullName,
                    'profile_image' => $qNAAnswer->author->profile_image,
                ],
                'parent_id' => $qNAAnswer->parent_id ?? null,
                'answer_by' => $data['answer_by'],
                'system' => activeGuard() ?? 'admin',
                'canEdit' => $canEdit
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QNAAnswer $qNAAnswer)
    {
        if ($qNAAnswer) {
            foreach ($qNAAnswer->children as $reply) {
                $reply->delete();
            }

            $qNAAnswer->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Reply not found'], 404);
        }
    }
}
