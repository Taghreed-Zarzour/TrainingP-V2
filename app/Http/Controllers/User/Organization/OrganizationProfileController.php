<?php
namespace App\Http\Controllers\User\Organization;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequests\updateOrganizationProfile;
use App\Models\Country;
use App\Models\Organization;
use App\Models\OrganizationSector;
use App\Models\OrganizationType;
use App\Models\EmployeeNumber;
use App\Models\AnnualBudget;
use App\Models\User;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationProfileController extends Controller
{
    protected $organizationService;
    
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }
    
public function showProfile($id = null)
{
    $id = $id ?? Auth::id();
    $user = User::with('country')->findOrFail($id);
    $organization = Organization::where('id', $id)
        ->with([
            'type', 
            'employeeNumber', 
            'annualBudget'
        ])
        ->firstOrFail();
    
    $countries = Country::all();
    
    // جلب بيانات الفروع من قاعدة البيانات
    $branches = [];
    if ($organization->branches) {
        // التحقق من نوع البيانات قبل فك تشفيرها
        if (is_array($organization->branches)) {
            $branches = $organization->branches;
        } else {
            $branches = json_decode($organization->branches, true);
        }
        
        // تحويل بيانات الفروع لتنسيق مناسب للعرض
        foreach ($branches as &$branch) {
            if (isset($branch['country_id'])) {
                $country = Country::find($branch['country_id']);
                $branch['country_name'] = $country ? $country->name : '';
            }
        }
    }
    
    $organization_workSectors = OrganizationSector::whereIn('id', $organization->organization_sectors ?? [])->get();
    $selected_country = Country::where('phonecode', ltrim($user->phone_code, '+'))->first();
    
    // بيانات القوائم للنموذج
    $organizationTypes = OrganizationType::all();
    $employeeNumbers = EmployeeNumber::all();
    $annualBudgets = AnnualBudget::all();
    $organizationSectors = OrganizationSector::all();
    
    return view('user.organization.show_profile',
    compact(
        'user',
        'organization',
        'countries',
        'organization_workSectors',
        'branches',
        'selected_country',
        'organizationTypes',
        'employeeNumbers',
        'annualBudgets',
        'organizationSectors'
    ));
}
    
public function updateProfile(updateOrganizationProfile $request){
    $data = $request->validated();
    
    // معالجة صورة الشعار
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $imageName);
        $data['photo'] = $imageName; // إضافة اسم الصورة إلى البيانات
    }
    
    // معالجة بيانات الفروع
    $branches = [];
    if (isset($data['branch_country_id']) && isset($data['branch_city'])) {
        $countryIds = $data['branch_country_id'];
        $cities = $data['branch_city'];
        
        for ($i = 0; $i < count($countryIds); $i++) {
            if (!empty($countryIds[$i]) && !empty($cities[$i])) {
                $branches[] = [
                    'country_id' => $countryIds[$i],
                    'city' => $cities[$i]
                ];
            }
        }
    }
    
    // إضافة بيانات الفروع إلى البيانات الرئيسية
    $data['branches'] = json_encode($branches);
    
    $response = $this->organizationService->updateProfile($data);
    if ($response['success'] == true) {
      return redirect()->route('show_organization_profile')->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }
}
}