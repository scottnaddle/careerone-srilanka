<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $user = Auth::guard(activeGuard())->user();
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
    public function markAsUnread(Request $request){

    }
    
    public function show(Request $request) {
        $user = Auth::guard(activeGuard())->user();
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No authenticated user found'], 401);
        }
    
        $notifications = $user->notifications;
    
     
        $currentPage = $request->get('page', 1); 
        $perPage = 10;
        $currentPageItems = $notifications->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedNotifications = new LengthAwarePaginator(
            $currentPageItems,
            $notifications->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
    
        return view('notifications.notification', compact('paginatedNotifications'));
    }
    public function saveTokenFcm(Request $request){
        if(!$request->session()->has('fcm_token')){
            session(['fcm_token' => $request->input('token')]);
            $token = session('fcm_token');
        }
    }
    

}
