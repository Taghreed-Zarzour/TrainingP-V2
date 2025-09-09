<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\OrgTrainingProgram;
use App\Models\TrainingProgram;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\EnrollmentRequest;
use App\Helpers\NotificationHelper;

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
                $trainer  = TrainingProgram::where('id',$program_id)->first();
                $trainer = User::where('id', $trainer->user_id)->first();
                if ($trainer) {

if ($trainer) {
    NotificationHelper::sendNotification(
        $trainer->id,
        'قام متدرب بتقديم طلب للانضمام إلى البرنامج.',
        'enrollmentRequest',
        [
            'enrollment_id' => $enrollment->id,
            'trainee_id' => $enrollment->trainee_id,
            'program_id' => $program_id,
            'is_org' => false
        ]
    );
}                }
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
                $orgtraining  = OrgTrainingProgram::where('id',$orgProgram_id)->first();
                $organization = User::where('id', $orgtraining->organization_id)->first();

if ($organization) {
    NotificationHelper::sendNotification(
        $organization->id,
        'قام متدرب بتقديم طلب للانضمام إلى البرنامج.',
        'enrollmentRequest',
        [
            'enrollment_id' => $enrollment->id,
            'trainee_id' => $enrollment->trainee_id,
            'program_id' => $orgProgram_id,
            'is_org' => true
        ]
    );
}
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
    public function getByStatus($status)
    {
        try{
            $enrollment = Enrollment::when($status, function ($query, $status) {
                $query->where('status', 'LIKE', "%{$status}%");
            })->get();
            return [
                'msg' => 'تم استرجاع البيانات',
                'success' => true,
                'data' => $enrollment
            ];
        }catch (\Exception $e) {
            return [
                'msg' => 'حدث خطأ أثناء استرجاع البيانات: ' . $e->getMessage(),
                'success' => false,
                'data' => []
            ];
        }
    }

}