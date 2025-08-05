<?php

namespace App\Http\Controllers\User\CompletionData;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviousTrainingRequests\deletePreviousTraining;
use App\Http\Requests\PreviousTrainingRequests\storePreviousTraining;
use App\Http\Requests\PreviousTrainingRequests\updatePreviousTraining;
use App\Services\PreviousTrainingService;
use Illuminate\Http\Request;

class PreviousTrainingController extends Controller
{
    protected $PreviousTraining;

    public function __construct(PreviousTrainingService $PreviousTraining)
    {
        $this->PreviousTraining = $PreviousTraining;
    }

    public function storePreviousTraining(storePreviousTraining $request)
{
    $validated = $request->validated();
    $trainerId = auth()->id();

    // البحث عن التدريب السابق المرتبط بالمدرب
    $previousTraining = \App\Models\PreviousTraining::where('trainer_id', $trainerId)->first();

    // إذا وُجد سجل قديم، نحذف باستخدام الـ ID الصحيح
    if ($previousTraining) {
        $this->PreviousTraining->delete($previousTraining->id);
    }

    // إضافة الفيديو الجديد
    $response = $this->PreviousTraining->store($validated);

    if ($response['success']) {
        return redirect()->route('show_trainer_profile')->with('success', $response['msg']);
    } else {
        return back()->withErrors(['error' => $response['msg']])->withInput();
    }
}


    public function updatePreviousTraining(storePreviousTraining $request, $id)
    {
        $validated = $request->validated();
        $response = $this->PreviousTraining->update($validated, $id);

        if ($response['success']) {
            return redirect()->route('show_trainer_profile')->with('success', $response['msg']);
        } else {
            return back()->withErrors(['error' => $response['msg']])->withInput();
        }
    }

    public function deletePreviousTraining(deletePreviousTraining $request, $id)
    {
        $response = $this->PreviousTraining->delete($id);

        if ($response['success']) {
            return redirect()->route('show_trainer_profile')->with('success', $response['msg']);
        } else {
            return back()->withErrors(['error' => $response['msg']]);
        }
    }

}
