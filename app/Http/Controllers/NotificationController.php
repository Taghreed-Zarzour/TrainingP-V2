<?php
namespace App\Http\Controllers;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    // public function sendFirebaseNotification(Request $request)
    // {
    //     $token = $request->input('token'); 
    //     $title = 'Your Notification Title';
    //     $body = 'Your notification body here';

    //     $this->firebaseService->sendNotification($token, $title, $body);

    //     return response()->json(['message' => 'Notification sent successfully']);
    // }
    
    protected $cacheDuration = 60; // دقيقة
    
    public function index()
    {
        $userId = Auth::id();
        $cacheKey = 'user_notifications_' . $userId;
        
        $notifications = Cache::remember($cacheKey, $this->cacheDuration, function() {
            return Auth::user()
                ->notifications()
                ->latest()
                ->limit(10)
                ->get(['id', 'data', 'created_at', 'read_at']);
        });
        
        if (request()->ajax()) {
            return response()->json($notifications);
        }
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        $userId = Auth::id();
        $cacheKey = 'user_notifications_' . $userId;
        Cache::forget($cacheKey);
        
        return redirect()->route('notifications.index');
    }
    
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        
        $userId = Auth::id();
        $cacheKey = 'user_notifications_' . $userId;
        Cache::forget($cacheKey);
        
        return redirect()->back();
    }
    
    // إضافة دالة جديدة لحفظ FCM Token
    // public function saveFcmToken(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required|string'
    //     ]);
        
    //     $user = Auth::user();
    //     $user->fcm_token = $request->token;
    //     $user->save();
        
    //     return response()->json(['success' => true]);
    // }
}