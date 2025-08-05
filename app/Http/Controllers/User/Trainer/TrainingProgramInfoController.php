<?php

namespace App\Http\Controllers\User\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingAnnouncementRequests\updateTrainingInfo;
use App\Models\additional_setting;
use App\Models\TrainingProgram;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TrainingProgramInfoController extends Controller
{

    public function deleteTrainigFile($program_id, $file_index)
    {
        $program = TrainingProgram::findOrFail($program_id);
        $files = $program->AdditionalSetting->training_files;

        $filePath = $files[$file_index];
        Storage::disk('public')->delete($filePath);
        unset($files[$file_index]);
        $program->AdditionalSetting->update([
            'training_files' => array_values($files)
        ]);

        return back()->with('success', 'تم حذف الملف بنجاح');
    }


 public function uploadTrainingFiles(Request $request, $program_id)
    {
        $request->validate([
            'training_files.*' => 'required|file|max:10240', // 10MB كحد أقصى
        ]);

        $program = TrainingProgram::findOrFail($program_id);
        $currentFiles = $program->AdditionalSetting->training_files ?? [];

        $uploadedFiles = collect($request->file('training_files'))->map(function ($file) {
            $originalName = $file->getClientOriginalName();
            $path = 'training_files';
            
            // إنشاء اسم فريد للملف
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $uniqueName = $filename . '_' . time() . '.' . $extension;

            $filePath = $file->storeAs($path, $uniqueName, 'public');
            return $filePath;
        })->toArray();

        $updatedFiles = array_merge($currentFiles, $uploadedFiles);

        $program->AdditionalSetting->update([
            'training_files' => $updatedFiles
        ]);

        return back()->with('success', 'تم رفع الملفات بنجاح');
    }




    public function updateTrainingInfo(updateTrainingInfo $request , $id)
    {
        $program = TrainingProgram::findOrFail($id);

        $data = $request->validated();

        $program->update([
            'description' => $data['description']
        ]);

        $program->detail->update([
            'requirements' => json_encode($data['requirements']),
            'target_audience' => json_encode($data['target_audience']),
            'learning_outcomes' => json_encode($data['learning_outcomes']),
            'benefits' => json_encode($data['benefits']),
        ]);

        $paymentMethod = $data['payment_method'] ?? null; // استخدام قيمة افتراضية null إذا لم يكن المفتاح موجودًا
// تعريف الرسالة الترحيبية الافتراضية
$WelcomeMessage = "شكرًا لتسجيلك في التدريب. يسعدنا أن تكون/ي جزءًا من هذا البرنامج، ونتطلع إلى رحلة مليئة بالتعلّم والتطوير.
سيتم مراجعة طلبك وإشعارك بالقبول أو الاعتذار في أقرب وقت، لذا تأكد/ي من متابعة بريدك الإلكتروني أو الإشعارات داخل المنصة.";

// تحديث البيانات
$program->AdditionalSetting->update([
    'payment_method' => $data['payment_method'] ?? null,
    'welcome_message' => $data['welcome_message'] ?? $WelcomeMessage
]);

        return redirect()->back()->with('success', 'تم تحديث معلومات التدريب بنجاح');
    }

    public function deleteProgramPhoto($program_id){
        $program = additional_setting::where('training_program_id', $program_id)->firstOrFail();

    if ($program->profile_image && Storage::disk('public')->exists($program->profile_image)) {
        Storage::disk('public')->delete($program->profile_image);

        $program->profile_image = null;
        $program->save();

        return redirect()->back()->with('success', 'تم حذف صورة البرنامج بنجاح.');
    }
}



    public function updateOrCreateProgramPhoto(Request $request, $program_id)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $program = additional_setting::where('training_program_id', $program_id)->firstOrFail();

    if ($program->profile_image && Storage::disk('public')->exists($program->profile_image)) {
        Storage::disk('public')->delete($program->profile_image);
    }

    $file = $request->file('profile_image');
    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = $file->getClientOriginalExtension();
    $uniqueName = $filename . '_' . time() . '.' . $extension;

    $filePath = $file->storeAs('profile_images', $uniqueName, 'public');

    $program->profile_image = $filePath;
    $program->save();

    return redirect()->back()->with('success', 'تم تحديث صورة البرنامج بنجاح.');
}

}
