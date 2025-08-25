<?php

namespace App\Http\Controllers\User\Assistant;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssistantRequests\completeRegisterRequest;
use App\Models\Assistant;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\ExperienceArea;
use App\Models\Language;
use App\Models\ProvidedService;
use App\Models\User;
use App\Services\AssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    protected $assistantService;

    public function __construct(AssistantService $assistantService)
    {
        $this->assistantService = $assistantService;
    }

    public function index(Request $request){
        $assistants = Assistant::with('user')->get();
        $services = ProvidedService::pluck('name', 'id');
        $experience_areas =ExperienceArea::pluck('name','id');
        return view('user.assistant.index',compact('assistants','services','experience_areas'));
      }


    public function showRegistrationForm($id)
    {
        $user = User::findOrFail($id);
        $countries = Country::all();
        $services = ProvidedService::all();
        $experience_areas = ExperienceArea::all();
        $nationalities = Country::all();
        $education_levels = EducationLevel::all();
        $languages = Language::all();

        return view('user.assistant.complete-register-form',
        compact('user', 'countries', 'services','experience_areas', 'nationalities' , 'education_levels', 'languages'));

    }

    public function completeRegister(completeRegisterRequest $request , $id){
        $validated = $request->validated();
        // dd($validated);
        $response = $this->assistantService->completeRegister($validated , $id);

        if ($response['success'] == true) {
            return redirect()->route('homePage', ['id' => $id])->with('success', $response['msg']);
        } else {
            return back()->withErrors(['error' => $response['msg']]);
        }
    }



}
