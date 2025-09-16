<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Messaging;

class OrgViewsNotification extends Notification
{
    use Queueable;

    protected $views;

    public function __construct($views)
    {
        $this->views = $views;
    }

    public function via($notifiable)
    {
        return ['database' , 'fcm']; // Add other channels as needed
    }

    public function toFcm($notifiable)
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token) 
            ->withNotification([
                'title' =>  'لقد تم مشاهدة برنامجك ' . $this->views . ' مرة.',
                'body' => $this->views ,
            ]);
    }
    public function toArray($notifiable)
    {
        return [
            'message' => 'لقد تم مشاهدة برنامجك ' . $this->views . ' مرة.', // Message in Arabic
            'views' => $this->views,
        ];
    }


}