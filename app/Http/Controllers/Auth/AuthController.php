<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\logoutRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Requests\AuthRequests\verfiyRequest;
use App\Models\UserType;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use App\Helpers\ResponseJson;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServices $authService)
    {
        $this->authService = $authService;

    }
    public function view()
{

    return view('homePage');
}

    public function ViewOrganization()
    {
            return view('homePageOrganization');
    }

    public function RegisterView()
{
    $userTypes = UserType::all();
    return view('auth.register', compact('userTypes'));
}


    public function RegisterViewOrganization()
{
    $userTypes = UserType::all();
    return view('auth.register_organaization', compact('userTypes'));
}

public function register(RegisterRequest $request)
{
    $validated = $request->validated();
    $response = $this->authService->register($validated);

    if ($response['success']) {
        return redirect()->route('verify-user-blade', ['id' => $response['data']->id])->with('success', $response['msg']);
    }

    return back()->withInput()->withErrors(['error' => $response['msg']]);
}


public function verifyUserView($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('register')->withErrors(['error' => 'User not found!']);
    }

    return view('auth.verify-user', compact('user'));
}


public function verifyUser($id)
{
    $result = $this->authService->verifyUser($id);

    if ($result['success']) {
        return redirect($result['data']['link'])->with('success', $result['msg']);
    } else {
        return redirect()->route('verify-user-blade', ['id' => $id])->withErrors(['error' => $result['msg']]);

    }
}

public function resendVerificationEmail(verfiyRequest $request, $id)
{
    $result = $this->authService->resendVerificationEmail($id);

    if (!$result['success']) {
        return back()->withErrors(['error' => $result['msg']]);
    }

    return back()->with('success', $result['msg']);
}


public function showLoginForm()
{
    return view('auth.login');
}


public function login(LoginRequest $request)
{
    $validated = $request->validated();
    $response = $this->authService->login($validated);

    if ($response['success'] == true) {
        if ($response['data']['user_type_id'] == 4) {
            return redirect()->route('homePageOrganization')->with('success', $response['msg']);
        } else {
            return redirect()->route('homePage')->with('success', $response['msg']);
        }
    } else {
        if (isset($response['redirectVerify']) && $response['redirectVerify'] === true) {
            return redirect(route('verify-user-blade', ['id' => $response['userId']]))->with('failed', $response['msg']);
        }
        if (isset($response['redirect'])) {
            return redirect($response['redirect'])->with('failed', $response['msg']);
        }
        return redirect()->route('login')->with('failed', $response['msg']);
    }
}

    public function logout(Request $request)
    {
        $response = $this->authService->logout($request);

        return view('index')->with('success', $response['msg']);
    }
    public function searchbyName(Request $request)
    {
        $query = $request->input('search_term');
        $results = $this->authService->searchByNameOrEmail($query);

        return response()->json($results);
    }
    public function search(Request $request)
{
    $query = $request->input('q');
    $userTypeId = $request->input('user_type_id'); 

    $results = $this->authService->searchByType($query, $userTypeId);

    return response()->json($results);
}

}
