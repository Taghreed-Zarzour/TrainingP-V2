<?php

namespace App\Http\Controllers\User\Trainer;

use App\Enums\SexEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerRequests\completeRegisterRequest;
use App\Models\Country;
use App\Models\ProvidedService;
use App\Models\Trainer;
use App\Models\TrainerRating;
use App\Models\User;
use App\Models\WorkField;
use App\Models\WorkSector;
use App\Services\TrainerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class TrainerController extends Controller
{
  protected $trainerService;

  public function __construct(TrainerService $trainerService)
  {
    $this->trainerService = $trainerService;
  }

  public function index(Request $request){
    $work_sectors = WorkSector::all();
    $provided_services = ProvidedService::all();
    $work_fields = WorkField::all();
    $countries = Country::all();
    $trainers = Trainer::with('user')->get();
    $services = ProvidedService::pluck('name', 'id');
    $work_fields_trainer =WorkField::pluck('name','id');
    $ratings =  TrainerRating::get();
    return view('user.trainer.index',compact('trainers','services','work_fields','ratings',
  'provided_services','countries','work_sectors','work_fields_trainer'
  ));}

  public function showRegistrationForm($id)
  {
    $user = User::findOrFail($id);
    $countries = Country::all();

    $sexs = SexEnum::cases();
    $work_sectors = WorkSector::all();
    $provided_services = ProvidedService::all();
    $work_fields = WorkField::all();

    return view(
      'user.trainer.complete-register-form',
      compact('user', 'countries',  'sexs', 'work_sectors', 'provided_services', 'work_fields')
    );

  }

public function completeRegister(completeRegisterRequest $request, $id)
{
    $validated = $request->validated();

    $response = $this->trainerService->completeRegister($validated, $id);

    if ($response['success']) {
        return redirect()->route('homePage', ['id' => $id])
               ->with('success', $response['msg']);
    } else {
        // إرجاع كل البيانات مع الخطأ
        return redirect()->back()
               ->withInput()
               ->withErrors(['error' => $response['msg']]);
    }
}


}
