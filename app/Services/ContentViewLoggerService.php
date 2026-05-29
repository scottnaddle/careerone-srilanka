<?php
namespace App\Services;

use App\Models\CareerExpertInterview;
use App\Models\Content;
use App\Models\ContentViewLog;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class ContentViewLoggerService
{
    public function logView(string $contentType, $contentId): array
    {
        $logData = [
            'success' => false,
            'message' => '',
            'content_id' => $contentId
        ];

        try {
            // Get user and device info
            $user = Auth::guard(activeGuard())->user();
            $device = (new Agent())->isMobile() ? 'mobile' : 'desktop';

            // Create view log
            ContentViewLog::create([
                'view_log' => [
                    'user_information' => $user?->only(['id', 'name', 'email']),
                    'content_id' => $contentId,
                    'content_type' => $contentType,
                    'ip_address' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                    'device' => $device,
                    'viewed_at' => now()->toDateTimeString(),
                ],
            ]);

            // Increase view count
            if ($this->increaseView($contentType, $contentId)) {
                $logData['success'] = true;
                $logData['message'] = 'View logged successfully';
            } else {
                $logData['message'] = 'View logged but failed to increment count';
            }

        } catch (\Exception $e) {
            \Log::error("View logging failed: {$e->getMessage()}", [
                'content_type' => $contentType,
                'content_id' => $contentId,
                'exception' => $e
            ]);

            $logData['message'] = 'Failed to log view';
            $logData['error'] = config('app.debug') ? $e->getMessage() : null;
        }

        return $logData;
    }

    public function increaseView(string $contentType, $contentId): bool
    {
        try {
            $model = match ($contentType) {
                'career_expert_interview' => CareerExpertInterview::class,
                'content' => Content::class,
                'resource' => Resource::class,
                default => throw new \InvalidArgumentException("Invalid content type: {$contentType}")
            };

            return (bool) $model::where('id', $contentId)->increment('views');

        } catch (\Exception $e) {
            \Log::error("View count increment failed: {$e->getMessage()}", [
                'content_type' => $contentType,
                'content_id' => $contentId,
                'exception' => $e
            ]);

            return false;
        }
    }
}
