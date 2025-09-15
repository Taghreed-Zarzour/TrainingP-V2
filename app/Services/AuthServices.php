<?php

namespace App\Services;

use App\Mail\CompleteProfileMail;
use App\Models\Assistant;
use App\Models\Organization;
use App\Models\Trainee;
use App\Models\Trainer;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
class AuthServices
{
    public function register($data)
{
    try {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->save();
        Auth::login($user);
        $routes = [
            1 => 'complete-trainer-register',
            2 => 'complete-assistant-register',
            3 => 'complete-trainee-register',
            4 => 'complete-organization-register',
        ];
        
        $routeName = $routes[$user->user_type_id] ?? 'home';
        
        $link = URL::temporarySignedRoute(
            $routeName,
            now()->addMinutes(15), // expires in 15 minutes
            ['id' => $user->id]
        );
        
        // Send mail with that link
        Mail::to($user->email)->send(new CompleteProfileMail($user, $link));
        return [
            'msg' => 'تم إنشاء الحساب بنجاح. تحقق من بريدك الإلكتروني لإكمال ملفك الشخصي.',
            'success' => true,
            'data' => $user
        ];
    } catch (\Exception $e) {
        return [
            'msg' => $e->getMessage(),
            'success' => false,
            'data' => []
        ];
    }
}

public function verifyUser($id)
{
    try {
        $user = User::findOrFail($id);
        if ($user->email_verified_at) {
            return [
                'success' => false,
                'msg' => 'تم التحقق من حسابك مسبقًا.',
                'data' => [],
                'code' => 'already_verified'
            ];
        }

        $user->email_verified_at = now();
        $user->save();

        $routes = [
            1 => 'complete-trainer-register',
            2 => 'complete-assistant-register',
            3 => 'complete-trainee-register',
            4 => 'complete-organization-register',
        ];
        $routeName = $routes[$user->user_type_id] ?? 'home';
        $link = URL::temporarySignedRoute(
            $routeName,
            now()->addMinutes(15),
            ['id' => $user->id] 
        );

        return [
            'success' => true,
            'msg' => 'تم التحقق من الحساب بنجاح يرجى تكملة معلومات الحساب.',
            'data' => [
                'link' => $link
            ]
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'msg' => 'حدث خطأ أثناء التحقق: ' . $e->getMessage(),
            'data' => [],
            'code' => 'exception'
        ];
    }
}

public function resendVerificationEmail($id)
{
    try {
        $user = User::findOrFail($id);

        if ($user->email_verified_at) {
            return [
                'msg' => 'تم التحقق من البريد الإلكتروني مسبقًا.',
                'success' => false,
                'data' => []
            ];
        }

        $routes = [
            1 => 'complete-trainer-register',
            2 => 'complete-assistant-register',
            3 => 'complete-trainee-register',
            4 => 'complete-organization-register',
        ];

        $routeName = $routes[$user->user_type_id] ?? 'home';

        $link = URL::temporarySignedRoute(
            $routeName,
            now()->addDays(1),
            ['id' => $user->id]
        );

        Mail::to($user->email)->send(new CompleteProfileMail($user, $link));

        return [
            'msg' => 'تم إرسال رابط التحقق مرة أخرى إلى بريدك الإلكتروني.',
            'success' => true,
            'data' => $user
        ];
    } catch (\Exception $e) {
        return [
            'msg' => 'حدث خطأ أثناء إعادة إرسال البريد الإلكتروني: ' . $e->getMessage(),
            'success' => false,
            'data' => []
        ];
    }
}



public function login(array $data)
{
    try {
        $remember = isset($data['remember']) ? (bool)$data['remember'] : false;

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            $user = Auth::user();

            if (isset($data['fcm_token'])) {
                $user->fcm_token = $data['fcm_token']; // Store the FCM token
                $user->save(); // Save the user
            }
            
            if (is_null($user->email_verified_at)) {
                $routes = [
                    1 => 'complete-trainer-register',
                    2 => 'complete-assistant-register',
                    3 => 'complete-trainee-register',
                    4 => 'complete-organization-register',
                ];
                
                $routeName = $routes[$user->user_type_id] ?? 'home';
                
                $link = URL::temporarySignedRoute(
                    $routeName,
                    now()->addDays(1),
                    ['id' => $user->id]
                );
                
                Mail::to($user->email)->send(new CompleteProfileMail($user, $link));
                Auth::logout();
                
                return [
                    'msg' => 'يرجى التحقق من بريدك الإلكتروني قبل تسجيل الدخول.',
                    'success' => false,
                    'redirectVerify' => true,
                    'userId' => $user->id
                ];
            }

            $routes = [
                1 => 'complete-trainer-register',
                2 => 'complete-assistant-register',
                3 => 'complete-trainee-register',
                4 => 'complete-organization-register',
            ];

            $profileExists = false;
            switch ($user->user_type_id) {
                case 1: // Trainer
                    $profileExists = Trainer::where('id', $user->id)->exists();
                    break;
                case 2: // Assistant
                    $profileExists = Assistant::where('id', $user->id)->exists();
                    break;
                case 3: // Trainee
                    $profileExists = Trainee::where('id', $user->id)->exists();
                    break;
                case 4: // Organization
                    $profileExists = Organization::where('id', $user->id)->exists();
                    break;
                default:
                    return [
                        'msg' => 'نوع المستخدم غير معروف.',
                        'success' => false,
                        'redirect' => null
                    ];
            }
            if (!$profileExists) {
                $routeName = $routes[$user->user_type_id] ?? 'home';
                $link = URL::temporarySignedRoute(
                    $routeName,
                    now()->addMinutes(50),
                    ['id' => $user->id] 
                );

                return [
                    'msg' => 'يرجى إكمال ملفك الشخصي.',
                    'success' => false,
                    'redirect' => $link
                ];
            }

            // Create session if the profile is complete
            session(['user_id' => $user->id, 'email' => $user->email]);
            if ($remember) {
                config(['session.lifetime' => 20160]); // 14 days
            }

            return [
                'msg' => 'تم تسجيل الدخول بنجاح.',
                'success' => true,
                'data' => $user
            ];
        }

        return [
            'msg' => 'فشل في تسجيل الدخول. يرجى التحقق من البيانات المدخلة.',
            'success' => false,
            'data' => []
        ];
    } catch (\Exception $e) {
        return [
            'msg' => 'حدث خطأ غير متوقع: ' . $e->getMessage(),
            'success' => false,
            'data' => []
        ];
    }
}

//logout
public function logout($request)
{
    try {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return [
            'msg' => 'تم تسجيل الخروج بنجاح.',
            'success' => true
        ];
    } catch (\Exception $e) {
        return [
            'msg' => 'حدث خطأ أثناء تسجيل الخروج: ' . $e->getMessage(),
            'success' => false
        ];
    }
}

    public function searchByNameOrEmail(?string $query): array
    {
        $users = User::when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%");
        })->limit(10)->get();

        return $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'type' => match((int) $user->user_type_id) {
                    1 => 'مدرب',
                    2 => 'مساعد',
                    default => 'غير معروف',
                },
                    ];
        })->toArray();
    }
    public function searchByType(?string $query, ?int $userTypeId): array
    {
        $users = User::when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('email', 'like', "%$query%");
        })
        ->when($userTypeId, function ($q) use ($userTypeId) {
            $q->where('user_type_id', $userTypeId);
        })
        ->limit(10)->get();
    
        return $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first() ?? 'غير محدد',
            ];
        })->toArray();
    }

}