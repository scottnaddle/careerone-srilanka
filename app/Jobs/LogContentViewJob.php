<?php

namespace App\Jobs;

use App\Models\CountView;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class LogContentViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contentId;
    public $userId;
    public $ipAddress;
    public $userAgent;
    public $viewedAt;
    public $system;
    public $type;

    public function __construct($contentId, $userId = null, $ipAddress = null, $userAgent = null,$system = null,$type=null)
    {
        $this->contentId = $contentId;
        $this->system = $system;
        $this->userId = $userId;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->viewedAt = now();
        $this->type = $type;
    }

    public function handle()
{
    $alreadyViewed = CountView::where('content_id', $this->contentId)
        ->where('system', $this->system)
        ->where('type', $this->type)
        ->where(function ($query) {
            if ($this->userId) {
                $query->where('user_id', $this->userId);
            } else {
                $query->where('ip_address', $this->ipAddress);
            }
        })
        ->whereDate('viewed_at', now()->toDateString())
        ->exists();

    if (! $alreadyViewed) {
        CountView::create([
            'content_id' => $this->contentId,
            'user_id' => $this->userId,
            'ip_address' => $this->ipAddress,
            'viewed_at' => $this->viewedAt,
            'type' => $this->type,
            'system' => $this->system ?? 'guest',
        ]);
    }
}

    
}

