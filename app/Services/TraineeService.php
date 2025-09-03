<?php

namespace App\Services;

use App\Models\Trainee;
use App\Notifications\RegistrationCompleted;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TraineeService
{
  public function completeRegister($data, $id)
  {
    try {
      DB::beginTransaction();
      $user = User::find($id);
      if(!isset($user->email_verified_at)){
        $user->email_verified_at = now();
        $user->save();
      }
      $user->update([
        'phone_number' => $data['phone_number'],
          'phone_code' => $data['phone_code'],
        'city' => $data['city'],
        'country_id' => $data['country_id'],
      ]);

      $user->setTranslations('name', [
        'ar' => $data['name_ar'],
      ])->save();

      // تصفية القيم لاستبعاد other
      $workFields = array_filter($data['work_fields'], function ($field) {
        return $field !== 'other';
      });

      // ... بقية الكود
      $traineeData['work_fields'] = $workFields;

      // تحضير بيانات المتدرب
      $traineeData = [
        'id' => $user->id,
        'education_levels_id' => $data['education_levels_id'],
        'work_fields' => array_values($workFields), // تحوي فقط IDs
        'extra_work_field' => in_array('other', $data['work_fields'])
          ? $data['extra_work_field']
          : null,
        'nationality' => $data['nationality'],
        'sex' => $data['sex'],
        'is_working' => $data['is_working'],
        'fields_of_interest' => $data['fields_of_interest'],
        'preferred_times' => $data['preferred_times'],
        'training_attendance' => $data['training_attendance'],
        'investment_value' => $data['investment_value'],
      ];

      // إضافة حقول العمل إذا كان يعمل
      if ($data['is_working'] == 1) {
        $traineeData['job_position'] = $data['job_position'];
        $traineeData['work_sectors'] = $data['work_sectors'];
      }

      $trainee = new Trainee();
      $trainee->fill($traineeData)
        ->setTranslations('last_name', ['ar' => $data['last_name_ar']])
        ->save();

      DB::commit();
      $user->notify(new RegistrationCompleted('Thank you for completing your profile!'));
      return [
        'msg' => 'تم تخزين البيانات بنجاح',
        'success' => true,
        'data' => [
          'user' => $user,
          'trainee' => $trainee
        ]
      ];
    } catch (\Exception $e) {
      DB::rollBack();
      return [
        'msg' => 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage(),
        'success' => false,
        'data' => []
      ];
    }
  }

  public function updatePersonalInfo($data)
  {
    try {
      $id = Auth::id();
      DB::beginTransaction();

      $user = User::findOrFail($id);
      $user->update([

        'phone_number' => $data['phone_number'],
          'phone_code' => $data['phone_code'],
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

      $trainee = Trainee::findOrFail($user->id);

      $trainee->update([
        'nationality' => $data['nationality'],
      ]);

      $trainee->setTranslations('last_name', [
        'en' => $data['last_name_en'],
        'ar' => $data['last_name_ar'],
      ]);

      $trainee->save();

      $user->nationalities()->sync($data['nationality']);
      DB::commit();

      return [
        'msg' => 'تم تخزين البيانات.',
        'success' => true,
        'data' => [
          'user' => $user,
          'trainer' => $trainee
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

  public function updateProfessionalData($data)
  {
    try {
      $id = Auth::id();
      DB::beginTransaction();

      $user = User::findOrFail($id);
      $trainee = Trainee::findOrFail($user->id);

      $trainee->update([
        'job_position' => $data['job_position'],
        'training_attendance' => $data['training_attendance'],
        'work_institution' => $data['work_institution'],
        'fields_of_interest' => $data['fields_of_interest'],
      ]);

      $trainee->save();

      DB::commit();

      return [
        'msg' => 'تم تخزين البيانات.',
        'success' => true,
        'data' => [
          'user' => $user,
          'trainer' => $trainee
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

  public function updatePreferredTimes($data)
  {
    try {
      $id = Auth::id();

      DB::beginTransaction();
      $user = User::findOrFail($id);
      $trainee = Trainee::findOrFail($user->id);

      $trainee->update([
        'preferred_times' => $data['preferred_times'],
      ]);

      $trainee->save();

      DB::commit();

      return [
        'msg' => 'تم تخزين البيانات.',
        'success' => true,
        'data' => [
          'user' => $user,
          'trainer' => $trainee
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


