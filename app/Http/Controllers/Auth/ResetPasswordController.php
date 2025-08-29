<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\resetPasswordRequest;
use App\Http\Requests\AuthRequests\sendResetLinkRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }


    public function sendResetLinkEmail(sendResetLinkRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email',$data['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with that email.']);
        }

        $token = Password::createToken($user);

        $url = url("/reset-password/{$token}?email=" . urlencode($user->email));

        Mail::to($user->email)->send(new ResetPasswordMail($url, $user));

        return back()->with('status', 'Password reset email sent successfully.');

    }


    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }


    public function resetPassword(resetPasswordRequest $request)
    {
        $data = $request->validated();

    $status = Password::reset($data, function ($user, $password) {
        $user->update([
            'password' => Hash::make($password),
        ]);
    });

    if ($status === Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('status', 'تم تغيير كلمة المرور بنجاح.');
    }

    return back()->withErrors(['email' => 'حدث خطأ أثناء تغيير كلمة المرور.']);
}



}



