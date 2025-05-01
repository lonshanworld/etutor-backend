<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user with pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllNotifications(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        $perPage = $request->input('per_page', 10);
        
        $notifications = $user->notifications()->select('id', 'data', 'read_at', 'created_at', 'updated_at')->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'data' => $notifications->items(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'last_page' => $notifications->lastPage(),
                'has_more_pages' => $notifications->hasMorePages(),
            ],
            'unread_count' => $user->unreadNotifications->count(),
        ]);
    }
    
    /**
     * Mark notification as read
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        if ($request->has('uuid')) {
            $notification = $user->notifications()->find($request->uuid);
            if ($notification) {
                $notification->markAsRead();
            }
        } else {
            $user->unreadNotifications->markAsRead();
        }
        
        return response()->json(['message' => 'Notifications marked as read']);
    }
}
