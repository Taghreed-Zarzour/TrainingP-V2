<?php

namespace App\Services;

use App\Models\TrainingProgram;
use Carbon\Carbon;

class TrainingAnnouncementService
{

    protected TrainingProgramServices $trainingProgramServices;

    public function __construct(TrainingProgramServices $trainingProgramServices)
    {
        $this->trainingProgramServices = $trainingProgramServices;
    }

    public function index($filters = null , $search = null ): array
  {
        $allPrograms = TrainingProgram::with(
            'detail',
            'AdditionalSetting',
            'sessions',
            'assistants'
        )
        ->where('status', 'online')
        ->applyFilters($filters)
        ->searchTitle($search)
        ->get();


    $announced = [];
    $now = Carbon::now();


    foreach ($allPrograms as $program) {
        // حساب نسبة الإكمال
        $completion = $this->trainingProgramServices->calculateCompletion($program);

        // تحقق من نسبة الإكمال
        if ((int)$completion !== 100) {
            continue;
        }

        // تحقق من انتهاء التقديم
        $deadline = $program->AdditionalSetting->application_deadline ?? null;
        $deadlineValid = $deadline ? $now->lessThanOrEqualTo(Carbon::parse($deadline)->endOfDay()) : false;
        if (!$deadlineValid) {
            continue;
        }

        $sessions = collect($program->sessions);
        $hasSessions = !$sessions->isEmpty();

        // إذا لم توجد جلسات أو تم اختيار schedule_later
        if (!$hasSessions || ($program->AdditionalSetting && $program->AdditionalSetting->schedule_later)) {
            $announced[] = $program;
            continue;
        }

        // إذا توجد جلسات، تحقق من أول جلسة
        $firstSession = $sessions->sortBy('session_date')->first();
        if ($firstSession) {
            $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
            if ($startTime->isFuture()) {
                $announced[] = $program;
                continue;
            }
        }
    }

    return [
        'msg' => 'تم ارجاع البيانات بنجاح.',
        'success' => true,
        'data' => $announced
    ];
}


    public function getById($id){
        $program = TrainingProgram::with('detail','AdditionalSetting','sessions','assistants')->where('status','online')->find($id);
        return $program;
    }


    public function store($data)
    {
        $program = TrainingProgram::create($data);

        return [
            'msg' => 'تم تخزين البيانات بنجاح.',
            'success' => true,
            'data' => $program
        ];
    }


}
