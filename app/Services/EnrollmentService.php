<?php

namespace App\Services;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{
    public function store($program_id = null, $orgProgram_id = null)
    { 
        try {
            DB::beginTransaction();

            $trainee_id = Auth::id();

            // Determine which program ID is being used
            if ($program_id) {
                $existing = Enrollment::where('trainee_id', $trainee_id)
                    ->where('training_programs_id', $program_id)
                    ->first();

                if ($existing) {
                    return [
                        'msg' => 'لقد قمت بالتسجيل في هذا البرنامج من قبل.',
                        'success' => false,
                        'data' => []
                    ];
                }

                $enrollment = Enrollment::create([
                    'trainee_id' => $trainee_id,
                    'training_programs_id' => $program_id,
                    'status' => 'pending',
                    'org_training_programs_id' => null,
                    'registered_at' => now(),
                ]);
            } elseif ($orgProgram_id) {
                $existing = Enrollment::where('trainee_id', $trainee_id)
                    ->where('org_training_programs_id', $orgProgram_id)
                    ->first();

                if ($existing) {
                    return [
                        'msg' => 'لقد قمت بالتسجيل في هذا البرنامج من قبل.',
                        'success' => false,
                        'data' => []
                    ];
                }

                $enrollment = Enrollment::create([
                    'trainee_id' => $trainee_id,
                    'org_training_programs_id' => $orgProgram_id,
                    'status' => 'pending',
                    'training_programs_id'=>null,
                    'registered_at' => now(),
                ]);
            } else {
                return [
                    'msg' => 'يجب تحديد معرف البرنامج.',
                    'success' => false,
                    'data' => []
                ];
            }

            DB::commit();
            return [
                'msg' => 'تم ارسال طلبك بنجاح',
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