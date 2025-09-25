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
        $this->messaging = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json')) // Adjust this path
            ->createMessaging();
    }

    public function sendNotification($token, $title, $body)
    {
        $message = CloudMessage::new()->toToken($token)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ]);

        $this->messaging->send($message);
    }

    public function sendToUser($userId, $title, $body, $data = [])
    {
        try {
            // Get user's FCM token from database
            $user = \App\Models\User::find($userId);
            
            if (!$user || !$user->fcm_token) {
                Log::warning("User {$userId} not found or has no FCM token");
                return false;
            }

            // Create the message
            $message = CloudMessage::new()->toToken($user->fcm_token)
                ->withNotification([
                    'title' => $title,
                    'body' => $body,
                ])
                ->withData($data);

            // Send the message
            $result = $this->messaging->send($message);
            
            Log::info("Firebase notification sent successfully to user {$userId}", [
                'message_id' => $result,
                'title' => $title,
                'body' => $body
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            dd($e);
            Log::error("Failed to send Firebase notification to user {$userId}", [
                'error' => $e->getMessage(),
                'title' => $title,
                'body' => $body
            ]);
            
            return false;
        }
    }
}