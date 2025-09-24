<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequests\updateDetialInfo;
use App\Models\OrgTrainingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingDetailController extends Controller
{
    public function updateInfo(updateDetialInfo $request, $id)
    {
        $programDetail = OrgTrainingDetail::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $path = 'trainingDetail/image/' . $originalName;

            $request->file('image')->storeAs('trainingDetail/image', $originalName, 'public');

            if ($programDetail->image) {
                Storage::disk('public')->delete($programDetail->image);
            }

            $data['image'] = $path;
        }

        $programDetail->fill($data);
        $programDetail->save();

        return redirect()->back()->with('success', 'تم تحديث بيانات التدريب بنجاح');
    }

    public function deleteInfo(Request $request, $id)
    {
        $programDetail = OrgTrainingDetail::findOrFail($id);

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

        return redirect()->back()->with('success', 'Selected fields deleted successfully');
    }
}
