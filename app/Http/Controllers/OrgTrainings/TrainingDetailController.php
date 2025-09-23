<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequests\addAssisstantRequest;
use App\Http\Requests\OrganizationRequests\updateDetialInfo;
use App\Models\OrgAssistantManagement;
use App\Models\OrgTrainingDetail;
use App\Models\Language;
use App\Models\TrainingClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingDetailController extends Controller
{
    public function updateInfo(updateDetialInfo $request, $id)
{
    $programDetail = OrgTrainingDetail::findOrFail($id);
    $data = [];

    if ($request->hasFile('image')) {
        $originalName = $request->file('image')->getClientOriginalName();
        $path = 'trainingDetail/image/' . $originalName;

        $request->file('image')->storeAs('trainingDetail/image', $originalName, 'public');

        if ($programDetail->image) {
            Storage::disk('public')->delete($programDetail->image);
        }

        $data['image'] = $path;
    }


    if ($request->has('program_description')) {
        $data['program_description'] = $request->program_description;
    }

    if ($request->has('learning_outcomes')) {
        $data['learning_outcomes'] = json_encode($request->learning_outcomes);
    }

    if ($request->has('program_type')) {
        $data['program_type'] = $request->program_type;
    }

    if ($request->has('language_id')) {
        $data['language_id'] = $request->language_id;
    }

    if ($request->has('classification')) {
        $data['classification'] = json_encode($request->classification);
    }

    if ($request->has('program_presentation_method')) {
        $data['program_presentation_method'] = $request->program_presentation_method;
    }

    if ($request->has('assistant_id')) {
        $data['assistant_id'] = $request->assistant_id;
    }
    $programDetail->fill($data);

    $programDetail->save();

    return redirect()->back()->with('success', 'تم تحديث بيانات التدريب بنجاح');
}

    public function deleteInfo(Request $request, $id)
    {
        $programDetail = OrgTrainingDetail::findOrFail($id);

        if ($request->has('program_title')) {
            $programDetail->program_title = null;
        }

        if ($request->has('program_description')) {
            $programDetail->program_description = null;
        }

        if ($request->has('learning_outcomes')) {
            $programDetail->learning_outcomes = null;
        }

        if ($request->has('program_type')) {
            $programDetail->program_type = null;
        }

        if ($request->has('language_id')) {
            $programDetail->language_id = null;
        }

        if ($request->has('classification')) {
            $programDetail->classification = null;
        }

        if ($request->has('program_presentation_method')) {
            $programDetail->program_presentation_method = null;
        }

        if ($request->has('image')) {
            if ($programDetail->image) {
                Storage::disk('public')->delete($programDetail->image);
            }
            $programDetail->image = null;
        }

        if ($request->has('assistant_id')) {
            $programDetail->assistant_id = null;
        }

        $programDetail->save();

        return redirect()->back()->with('success', 'تم حذف البيانات المحددة بنجاح');
    }
    public function viewAssistant(Request $request , $id){
        $programDetail = OrgTrainingDetail::findOrFail($id);
        $orgTrainingProgramId = $programDetail->org_training_program_id;
        $orgAssistants = OrgAssistantManagement::where('org_training_program_id',$orgTrainingProgramId)
        ->get();
        return redirect()->back()->with('orgAssistants', $orgAssistants);
    }

    public function addAssistant(addAssisstantRequest $request, $id){
        $programDetail = OrgTrainingDetail::findOrFail($id);
        $validatedData = $request->validated();
        $programDetail->fill([
            'assistant_id' => $validatedData['assistant_id']
        ]);
        $programDetail->save();
        return redirect()->back()->with('success', 'تم أضافة مساعد جديد بنجاح');
    }
    public function deleteAssistant(Request $request , $id){
        $programDetail = OrgTrainingDetail::findOrFail($id);
        $programDetail->assistant_id = null;
        $programDetail->save();
        return redirect()->back()->with('success', 'تم حذف مساعد بنجاح');
    }
}