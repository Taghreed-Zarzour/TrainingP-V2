<?php
namespace App\Services;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Illuminate\Support\Facades\Log;
class FirebaseService
{
    protected $messaging;
    
    public function __construct()
    {
        // ضع ملف الاعتماد في storage/app/firebase-service-account.json
        $serviceAccount = storage_path('app/firebase-service-account.json');
        $factory = (new Factory)->withServiceAccount($serviceAccount);
        $this->messaging = $factory->createMessaging();
    }
    
    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        try {
            $notification = FirebaseNotification::create($title, $body);
            
            $message = CloudMessage::withTarget('token', $deviceToken)
                ->withNotification($notification)
                ->withData($data);
            
            $this->messaging->send($message);
            
            Log::info('Firebase notification sent', [
                'token' => substr($deviceToken, 0, 10) . '...',
                'title' => $title,
                'body' => $body
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Firebase notification error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function sendToUser($userId, $title, $body, $data = [])
    {
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->fcm_token) {
            return false;
        }
        
        return $this->sendNotification($user->fcm_token, $title, $body, $data);
    }
}