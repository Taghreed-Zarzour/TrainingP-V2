<?php
namespace App\Helpers;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
class NotificationHelper
{
    public static function sendToCurrentUser($message, $type = 'info')
    {
        $user = auth()->user();
        if (!$user) return false;
        
        // حفظ الإشعار في قاعدة البيانات
        $notification = $user->notifications()->create([
            'type' => 'App\Notifications\DatabaseNotification',
            'data' => [
                'message' => $message,
                'type' => $type,
                'time' => now()->toDateTimeString()
            ]
        ]);
        
        // إرسال الإشعار عبر Firebase إذا كان لدى المستخدم token
        if ($user->fcm_token) {
            $firebaseService = app(FirebaseService::class);
            $firebaseService->sendToUser(
                $user->id,
                'إشعار جديد',
                $message,
                [
                    'type' => $type,
                    'notification_id' => $notification->id
                ]
            );
        }
        
        return $notification;
    }
    
    public static function sendNotification($userId, $message, $type = 'info', $data = [])
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }
        
        $notificationData = array_merge([
            'message' => $message,
            'type' => $type,
        ], $data);
        
        $notification = $user->notifications()->create([
            'type' => 'App\Notifications\DatabaseNotification',
            'data' => $notificationData
        ]);
        
        // إرسال الإشعار عبر Firebase إذا كان لدى المستخدم token
        if ($user->fcm_token) {
            $firebaseService = app(FirebaseService::class);
            $firebaseService->sendToUser(
                $user->id,
                'إشعار جديد',
                $message,
                array_merge($data, [
                    'type' => $type,
                    'notification_id' => $notification->id
                ])
            );
        }
        
        return $notification;
    }
}