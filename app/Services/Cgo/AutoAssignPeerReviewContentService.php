<?php

namespace App\Services\Cgo;

use App\Models\CgoUser;
use App\Models\Content;
use App\Models\PeerContentReview;

class AutoAssignPeerReviewContentService {
    protected $notificationManager;
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    public function assign($content) {
        $threeCgoIds = CgoUser::whereNotNull('verify_at')
            ->where('id', '!=', $content->created_by)
            ->whereNotNull('verify_by')
            ->whereNotNull('email_verified_at')
            ->where('active', true)
            ->inRandomOrder()->limit(3)->pluck('id')->toArray();
        $existed = PeerContentReview::where('content_id', $content->id)->where('deleted_at', null)->first();
        if ($existed) {
            $existed->delete();
        }
        $peerReview = new PeerContentReview();
        $peerReview->content_id = $content->id;
        $peerReview->cgo_user_id_1 = $threeCgoIds[0] ?? null;
        $peerReview->cgo_user_id_2 = $threeCgoIds[1] ?? null;
        $peerReview->cgo_user_id_3 = $threeCgoIds[2] ?? null;
        $peerReview->save();
        foreach ($threeCgoIds as $id) {
            $cgo = CgoUser::where('id',$id)->first();
            if ($cgo) {
                $this->notificationManager->sendPeerReviewContentNotificationToCGO($cgo, $content);
            }

        }
    }
}
