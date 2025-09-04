<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        return ['database']; 
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