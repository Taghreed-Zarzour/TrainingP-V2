<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Messaging;

class RegistrationCompleted extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database' , 'fcm'];
    }

    public function toFcm($notifiable)
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token) 
            ->withNotification([
                'title' =>"تم اكتمال تسجيل حسابك",
                'body' =>$this->message
                ]);
    }
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'created_at' => now(),
        ];
    }
}