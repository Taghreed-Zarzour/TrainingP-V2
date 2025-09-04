<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        return ['database']; // Add other channels as needed
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'لقد تم مشاهدة برنامجك ' . $this->views . ' مرة.', // Message in Arabic
            'views' => $this->views,
        ];
    }


}