<?php

namespace App\Services;

use App\Models\Assistant;
use App\Notifications\RegistrationCompleted;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;
class AssistantService
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
                'ar' => $data['name_ar'],
            ]);

            $user->save();

            $Assistant = new Assistant();
            $Assistant->fill([
                'id' =>$user->id,
                'headline' => $data['headline'],
                'nationality' => $data['nationality'],
                'sex' => $data['sex'],
                'years_of_experience' =>$data['years_of_experience'],
                'provided_services' => $data['provided_services'],
                'experience_areas' => $data['experience_areas'],
                'specialization' => $data['specialization'],
                'university' => $data['university'],
                'graduation_year' => $data['graduation_year'],
                'education_levels_id' => $data['education_levels_id'],
                'languages' => $data['languages'],
            ]);

            $Assistant->setTranslations('last_name', [
                'ar' => $data['last_name_ar'],
            ]);
            $Assistant->save();

            DB::commit();


NotificationHelper::sendToCurrentUser(
    'شكرًا لك على إكمال ملفك الشخصي!',
    'registrationCompleted'
);            return [
                'msg' => 'تم تخزين البيانات.',
                'success' => true,
                'data'=> [
                    'user' => $user,
                    'Assistant' => $Assistant
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

   public function updatePersonalInfo($data){
    try {
        $id = Auth::id();
        DB::beginTransaction();
        $user = User::findOrFail($id);

        $user->update([
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

        $assistant = Assistant::findOrFail($user->id);

        $assistant->update([
          'nationality' => $data['nationality'],
        ]);

        $assistant->setTranslations('last_name', [
          'en' => $data['last_name_en'],
          'ar' => $data['last_name_ar'],
        ]);

        $assistant->save();
        $user->nationalities()->sync($data['nationality']);
        DB::commit();

        return [
          'msg' => 'تم تخزين البيانات.',
          'success' => true,
          'data' => [
            'user' => $user,
            'assistant' => $assistant
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

   public function updateExperienceAndEducation($data){
    try {
        $id = Auth::id();
        DB::beginTransaction();

        $user = User::findOrFail($id);
        $user->update([
            'bio' => $data['bio'],
        ]);

        $assistant = Assistant::findOrFail($user->id);

        $assistant->update([
          'years_of_experience' => $data['years_of_experience'],
          'experience_areas' => $data['experience_areas'],
          'provided_services' => $data['provided_services'],
          'university' => $data['university'],
          'specialization' => $data['specialization'],
          'graduation_year' => $data['graduation_year'],
          'education_levels_id' => $data['education_levels_id'],
        ]);

        $assistant->save();

        DB::commit();

        return [
          'msg' => 'تم تخزين البيانات.',
          'success' => true,
          'data' => [
            'user' => $user,
            'trainer' => $assistant
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
