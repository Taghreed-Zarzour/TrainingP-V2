<?php

namespace App\Services;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{
    public function store($program_id)
    {
      try {
        DB::beginTransaction();
        $trainee_id= Auth::id();
        $training_programs_id = $program_id;
        
        $existing = Enrollment::where('trainee_id', $trainee_id)
            ->where('training_programs_id', $training_programs_id)
            ->first();

        if ($existing) {
            return [
                'msg' => 'لقد قمت بالتسجيل في هذا البرنامج من قبل.',
                'success' => false,
                'data' => []
            ];
        }
        
        $enrollment= Enrollment::create([
            'trainee_id' => $trainee_id,
            'training_programs_id' =>  $training_programs_id,
            'status' =>  'pending',
            'registered_at' =>  now(),
        ]);
  
        DB::commit();
        return [
          'msg' => 'تم ارسال طلبك  بنجاح',
          'success' => true,
          'data' => [
            'enrollment' => $enrollment,
          ]
        ];
      } catch (\Exception $e) {
        DB::rollBack();
        return [
          'msg' => 'حدث خطأ أثناء التسجيل: ' . $e->getMessage(),
          'success' => false,
          'data' => []
        ];
      }
    }
}