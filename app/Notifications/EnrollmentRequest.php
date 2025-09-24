<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Messaging;

class EnrollmentRequest extends Notification
{
    use Queueable;

    protected $enrollment;
    protected $is_org;

    public function __construct($enrollment , $is_org)
    {
        $this->enrollment = $enrollment;
        $this->is_org = $is_org;
    }

    public function via($notifiable)
    {
        return ['database' , 'fcm'];
    }
    public function toFcm($notifiable)
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token) 
            ->withNotification([
                'title' =>'قام متدرب بتقديم طلب للانضمام إلى البرنامج.',
                'body' => [
                    'enrollment_id' => $this->enrollment->id,
                    'trainee_id' => $this->enrollment->trainee_id,
                    'program_id' => $this->enrollment->training_programs_id ?? $this->enrollment->org_training_programs_id,
                    'type' => 'enrollmentRequest',
                    'is_org' => $this->is_org,
                ],
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'قام متدرب بتقديم طلب للانضمام إلى البرنامج.',
            'enrollment_id' => $this->enrollment->id,
            'trainee_id' => $this->enrollment->trainee_id,
            'program_id' => $this->enrollment->training_programs_id ?? $this->enrollment->org_training_programs_id,
            'type' => 'enrollmentRequest',
            'is_org' => $this->is_org,
        ];
    }
}