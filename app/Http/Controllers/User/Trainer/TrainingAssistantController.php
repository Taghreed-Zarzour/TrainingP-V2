<?php

namespace App\Http\Controllers\User\Trainer;

use App\Http\Controllers\Controller;
use App\Models\trainingAssistantManagement;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class TrainingAssistantController extends Controller
{
    public function deleteProgramAssistant($assistant_id, $program_id)
    {
        $assistant = TrainingAssistantManagement::where('training_program_id', $program_id)
        ->where('assistant_id', $assistant_id)
        ->first();
        $assistant->delete();

        return redirect()->back()->with('success', 'تم حذف المساعد بنجاح');
    }

    // public function addProgramAssistant(Request $request, $assistant_id, $program_id)
    // {
    //     $trainer_id = TrainingProgram::where('id',$program_id)->value('user_id');
    //     $programAssistant = TrainingAssistantManagement::create([
    //         'trainer_id'=> $trainer_id,
    //         'assistant_id'=> $assistant_id,
    //         'training_program_id'=> $program_id,
    //     ]);

    //     return redirect()->back()->with('success', 'تم اضافة المساعد بنجاح');
    // }

public function addProgramAssistant(Request $request, $assistant_id, $program_id)
{
    // التحقق إذا كان هذا المساعد مضاف مسبقًا لهذا البرنامج
    $exists = TrainingAssistantManagement::where('training_program_id', $program_id)
        ->where('assistant_id', $assistant_id)
        ->exists();

    if ($exists) {
        return redirect()->back()->with('error', 'هذا المساعد مضاف مسبقًا لهذا التدريب.');
    }

    $trainer_id = TrainingProgram::where('id', $program_id)->value('user_id');

    TrainingAssistantManagement::create([
        'trainer_id' => $trainer_id,
        'assistant_id' => $assistant_id,
        'training_program_id' => $program_id,
    ]);

    return redirect()->back()->with('success', 'تم إضافة المساعد بنجاح.');
}



}
