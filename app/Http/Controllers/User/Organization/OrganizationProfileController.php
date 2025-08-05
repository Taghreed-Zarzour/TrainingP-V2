<?php

namespace App\Http\Controllers\User\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequests\updateOrganizationProfile;
use App\Models\Country;
use App\Models\Organization;
use App\Models\OrganizationSector;
use App\Models\User;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationProfileController extends Controller
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    public function showProfile()
    {
        $id = Auth::id();
        $user = User::with('country',)->findOrFail($id);
        $organization = Organization::where('id', $id)->with('annualBudget')->firstOrFail();
        $countries = Country::all();
        $branches = $organization->branches ?? [];

        $organization_workSectors = OrganizationSector::whereIn('id', $organization->organization_sectors ?? [])->get();

        $selected_country = Country::where('phonecode', ltrim($user->phone_code, '+'))->first();

        return view('user.organization.show_profile',
        compact('user','organization','countries','organization_workSectors','branches','selected_country'));
    }

    public function updateProfile(updateOrganizationProfile $request){
        $data = $request->validated();

        $response = $this->organizationService->updateProfile($data);

        if ($response['success'] == true) {
          return redirect()->route('show_organization_profile')->with('success', $response['msg']);
        } else {
          return back()->withErrors(['error' => $response['msg']]);
        }
    }

}
