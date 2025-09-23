<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequests\updateDetialInfo;
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

        // معالجة الحقول المتعددة مثل أهداف التعلم والتصنيفات
        if ($request->has('learning_outcomes')) {
            $data['learning_outcomes'] = json_encode($request->learning_outcomes);
        }

        if ($request->has('classification')) {
            $data['classification'] = json_encode($request->classification);
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

    // دالة جديدة لتحديث حقول محددة
    public function updateField(Request $request, $id)
    {
        $programDetail = OrgTrainingDetail::findOrFail($id);
        
        $fieldName = $request->input('field_name');
        $fieldValue = $request->input('field_value');
        
        // التحقق من أن الحقل مسموح بتحديثه
        $allowedFields = [
            'program_title', 'program_description', 'learning_outcomes', 
            'program_type', 'language_id', 'classification', 
            'program_presentation_method'
        ];
        
        if (!in_array($fieldName, $allowedFields)) {
            return response()->json(['error' => 'غير مسموح بتحديث هذا الحقل'], 403);
        }
        
        // معالجة القيم الخاصة
        if ($fieldName === 'learning_outcomes' || $fieldName === 'classification') {
            $fieldValue = json_encode($fieldValue);
        }
        
        $programDetail->$fieldName = $fieldValue;
        $programDetail->save();
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحقل بنجاح',
            'field_name' => $fieldName,
            'field_value' => $fieldValue
        ]);
    }
    
    // دالة جديدة لحذف حقول محددة
    public function deleteField(Request $request, $id)
    {
        $programDetail = OrgTrainingDetail::findOrFail($id);
        
        $fieldName = $request->input('field_name');
        
        // التحقق من أن الحقل مسموح بحذفه
        $allowedFields = [
            'program_title', 'program_description', 'learning_outcomes', 
            'program_type', 'language_id', 'classification', 
            'program_presentation_method', 'image', 'assistant_id'
        ];
        
        if (!in_array($fieldName, $allowedFields)) {
            return response()->json(['error' => 'غير مسموح بحذف هذا الحقل'], 403);
        }
        
        // حذف الصورة من التخزين إذا كان الحقل هو image
        if ($fieldName === 'image' && $programDetail->image) {
            Storage::disk('public')->delete($programDetail->image);
        }
        
        $programDetail->$fieldName = null;
        $programDetail->save();
        
        return response()->json([
            'success' => true,
            'message' => 'تم حذف الحقل بنجاح',
            'field_name' => $fieldName
        ]);
    }
}