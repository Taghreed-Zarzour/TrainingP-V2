<?php

namespace App\Services;

use App\Models\TrainingProgram;

class TrainingAnnouncementService
{

    public function index(){
        $programs = TrainingProgram::with('detail','AdditionalSetting','sessions','assistants')->where('status','online')->get();
        return [
            'msg' => 'تم ارجاع البيانات بنجاح.',
            'success' => true,
            'data' => $programs
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
