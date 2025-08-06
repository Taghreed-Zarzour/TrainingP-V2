<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\storeFeedback;
use App\Models\feedback;
use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (is_null($user->email_verified_at)) {
                return redirect()->route('verify-user-blade', ['id' => $user->id])
                                ->with('msg', 'يرجى التحقق من بريدك الإلكتروني.');
            }

            $routes = [
                1 => 'complete-trainer-register',
                2 => 'complete-assistant-register',
                3 => 'complete-trainee-register',
                4 => 'complete-organization-register',
            ];

            $profileExists = $this->homeService->checkUserProfile($user);

            if (!$profileExists) {
                $routeName = $routes[$user->user_type_id] ?? 'home';
                return redirect()->route($routeName, ['id' => $user->id]);
            }
            if ($user->user_type_id == 4) {
                return redirect()->route('homePageOrganization');
            }

            return redirect()->route('homePage');
        }

        return view('index');
}

public function sendFeedback(storeFeedback $request)
{
    $data = $request->validated();

    feedback::create([
        'user_id' => auth()->check() ? auth()->id() : null,

        'content' => $data['content'],
    ]);

    return back()->with('success', 'تم إرسال المراجعة بنجاح!');
}

}