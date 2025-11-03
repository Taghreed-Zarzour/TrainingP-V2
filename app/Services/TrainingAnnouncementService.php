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

        // تحقق من انتهاء التقديم - استبعاد التدريبات التي انتهى موعد التقديم فيها
        $deadline = $program->AdditionalSetting->application_deadline ?? null;
        if ($deadline) {
            $deadlineValid = $now->lessThanOrEqualTo(Carbon::parse($deadline)->endOfDay());
            if (!$deadlineValid) {
                continue; // استبعاد التدريب إذا انتهى موعد التقديم
            }
        }

      $announced[] = $program;

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
