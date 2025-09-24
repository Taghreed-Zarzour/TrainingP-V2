<?php

namespace App\Services;

use App\Models\Organization;
use App\Notifications\RegistrationCompleted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Helpers\NotificationHelper;

class OrganizationService
{
   public function completeRegister($data , $id){
        try{
            DB::beginTransaction();
            $user = User::find($id);
            if(!isset($user->email_verified_at)){
                $user->email_verified_at = now();
                $user->save();
              }
            $user->update([
              'phone_code' => $data['phone_code'],
                'phone_number' => $data['phone_number'],
                'city' => $data['city'],
                'country_id' => $data['country_id'],
                'bio' => $data['bio'],
            ]);

            $user->setTranslations('name', [
                'en' => $data['name_en'],
                'ar' => $data['name_ar'],
            ]);

            $user->save();

            $branches = [];

            if (isset($data['branch_country_id'], $data['branch_city'])) {
                $branches = array_filter(
                    array_map(function ($countryId, $index) use ($data) {
                        $city = $data['branch_city'][$index] ?? null;

                        if ($countryId && $city) {
                            return [
                                'country_id' => $countryId,
                                'city' => $city,
                            ];
                        }

                        return null;
                    }, $data['branch_country_id'], array_keys($data['branch_country_id']))
                );
            }

            $organization = new Organization();
            $organization->fill([
                'id'                    => $user->id,
                'organization_type_id'   => $data['organization_type_id'],
                'organization_sectors'  => $data['organization_sectors'],
                'employee_numbers_id'   =>$data['employee_numbers_id'],
                'annual_budgets_id'     =>$data['annual_budgets_id'],
                'established_year'      =>$data['established_year'],
                'website'               =>$data['website'],
                'branches'             => $branches,
            ]);

            // dd($branches);

            $organization->save();

NotificationHelper::sendToCurrentUser(
    'شكرًا لك على إكمال ملفك الشخصي!',
    'registrationCompleted'
);            DB::commit();
            return [
                'msg' => 'تم تخزين البيانات.',
                'success' => true,
                'data'=> [
                    'user' => $user,
                    'organization' => $organization
                ]
            ];
        }catch(\Exception $e){
            DB::rollBack();
            return [
                'msg' => $e->getMessage(),
                'success' => false,
                'data' => []
            ];
        }
    }

public function updateProfile($data)
{
    try {
        $id = Auth::id();
        DB::beginTransaction();
        $user = User::findOrFail($id);

        $user->update([
            'bio' => $data['bio'],
            'phone_code' => $data['phone_code'],
            'phone_number' => $data['phone_number'],
            'city' => $data['city'],
            'country_id' => $data['country_id'],
          ]);

          $user->setTranslations('name', [
            'en' => $data['name_en'],
            'ar' => $data['name_ar'],
          ]);

          if (request()->hasFile('photo')) {
            $file = request()->file('photo');
            $path = $file->store('photos', 'public');
            $user->photo = $path;
          }

        $user->save();

        $organization = Organization::findOrFail($id);

        $organization->update([
            'organization_type_id' => $data['organization_type_id'],
            'website' => $data['website'],
            'employee_numbers_id' => $data['employee_numbers_id'],
            'established_year' => $data['established_year'],
            'annual_budgets_id' => $data['annual_budgets_id'],
            'organization_sectors'  => $data['organization_sectors'],

          ]);

        // Update branches if provided
        if (isset($data['branch_country_id'], $data['branch_city'])) {
            $branches = array_filter(
                array_map(function ($countryId, $index) use ($data) {
                    $city = $data['branch_city'][$index] ?? null;
                    if ($countryId && $city) {
                        return [
                            'country_id' => $countryId,
                            'city' => $city,
                        ];
                    }
                    return null;
                }, $data['branch_country_id'], array_keys($data['branch_country_id']))
            );
            $organization->branches = $branches;
        }

        $organization->save();

        DB::commit();
        return [
            'msg' => 'تم تحديث البيانات.',
            'success' => true,
            'data' => [
                'user' => $user,
                'organization' => $organization
            ]
        ];
    } catch (\Exception $e) {
        DB::rollBack();
        return [
            'msg' => $e->getMessage(),
            'success' => false,
            'data' => []
        ];
    }
}

}
