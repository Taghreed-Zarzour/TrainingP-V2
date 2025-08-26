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

    public function index(): array
    {
        $allPrograms = TrainingProgram::with(
            'detail',
            'AdditionalSetting',
            'sessions',
            'assistants'
        )
        ->where('status', 'online')
        ->get();
        

        $announced = [];
        foreach ($allPrograms as $program) {
            // ✅ Call the method from the other service
            $completion = $this->trainingProgramServices->calculateCompletion($program);
            if ((int)$completion === 100) {
                $sessions = collect($program->sessions);
                if ($program->sessions->isEmpty()) {
                    $announced[] = $program;
                    continue;
                }

                $firstSession = $sessions->sortBy('session_date')->first();

                if ($firstSession) {
                    $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                    if ($startTime->isFuture()) {
                        $announced[] = $program;
                        continue;
                    }
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
