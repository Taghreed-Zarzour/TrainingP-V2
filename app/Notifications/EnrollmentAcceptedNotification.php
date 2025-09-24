<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Messaging;

class EnrollmentAcceptedNotification extends Notification
{
    use Queueable;

    protected $programId;

    public function __construct($programId)
    {
        $this->programId = $programId;
    }

    public function via($notifiable)
    {
        return ['database' , 'fcm']; 
    }
    public function toFcm($notifiable)
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token) 
            ->withNotification([
                'title' => 'تم قبول تسجيلك في البرنامج ' . $this->programId,
                'body' => [
                    'program_id' => $this->programId,
                    'participant_id' => $notifiable->id,
                ],
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'تم قبول تسجيلك في البرنامج ' . $this->programId, 
            'program_id' => $this->programId,
            'participant_id' => $notifiable->id,
        ];
    }
}