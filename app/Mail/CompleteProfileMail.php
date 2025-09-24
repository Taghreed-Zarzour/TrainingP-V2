<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompleteProfileMail extends Mailable
{
    use Queueable, SerializesModels;

    protected  $user;
    protected $link;
    public function __construct(User $user , $link)
    {
        $this->user = $user;  // Pass user object instead of only link
        $this->link = $link;
    }

    public function build()
{
    return $this->subject('Complete Your Profile')
                ->view('emails.complete_profile')
                 ->text('emails.verify_plain') // نسخة نصية بسيطة
                ->with([
                    'user' => $this->user,
                    'link' => $this->link
                ]);
}

}