<?php 
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentRejectedNotification extends Notification
{
    use Queueable;

    protected $programId;
    protected $reason;

    public function __construct($programId, $reason)
    {
        $this->programId = $programId;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'تم رفض تسجيلك في البرنامج ' . $this->programId, // الرسالة باللغة العربية
            'program_id' => $this->programId,
            'participant_id' => $notifiable->id,
            'rejection_reason' => $this->reason, // سبب الرفض
        ];
    }
}