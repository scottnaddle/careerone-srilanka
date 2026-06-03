<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Enums\ApiResponseStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Institute;
use App\Models\NVQLevel;
use App\Models\Occupation;
use App\Models\Province;
use App\Models\Sector;
use App\Http\Controllers\Api\Trainee\BaseController as BaseController;
use App\Services\Trainee\ProvincesDistrictsService;
use App\Services\Trainee\TraineeJobService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class NotificationController extends BaseController
{
    public function getAllNotifications(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $lang = $request->get('lang', 'en');
        App::setLocale($lang);
        $notifications = $user->notifications()->paginate(10);
        foreach ($notifications as $notification) {
            $message = $notification->data['message'] ?? [];
            $translated = __(
                $message['key'] ?? $message['message'] ?? '',
                $message['params'] ?? []
            );

            // Sao chép data, sửa trong biến trung gian, rồi gán lại
            $data = $notification->data;
            $data['message']['message'] = $translated;
            $notification->data = $data;
        }
        $data = [
            'total' => $notifications->total(),
            'data' => $notifications,
            'status' => 200
        ];
        return $this->sendResponse($data, 'Get notifications successfully!');
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No authenticated user found'], 401);
        }

        $notification = $user->notifications->find($request->id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function markAllRead()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No authenticated user found'], 401);
        }

        $notifications = $user->notifications;

        if ($notifications) {
            foreach ($notifications as $notification) {
                if ($notification->read_at === null) {
                    $notification->markAsRead();
                }
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false], 404);
    }
}
