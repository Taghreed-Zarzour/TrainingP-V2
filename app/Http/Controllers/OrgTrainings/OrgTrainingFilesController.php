<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Models\OrgTrainingDetailFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrgTrainingFilesController extends Controller
{
    public function uploadOrgTrainingFiles(Request $request, $program_id)
    {
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            // احصل على اسم الملف الأصلي
            $originalName = $uploadedFile->getClientOriginalName();

            $path = $uploadedFile->storeAs('training/files', $originalName, 'public');

            OrgTrainingDetailFile::create([
                'org_training_program_id' => $program_id,
                'training_files' => $path,
            ]);

            return back()->with('success', 'تم رفع الملف بنجاح');
        }

        return back()->with('error', 'يرجى اختيار ملف للرفع');
    }


  public function deleteOrgTrainingFile($id)
{
    $file = OrgTrainingDetailFile::findOrFail($id);

    Storage::disk('public')->delete($file->training_files);

    $file->delete($file->training_files);

    if (!isset($file)) {
        return back()->withErrors('الملف المطلوب غير موجود');
    }

    return back()->with('success', 'تم حذف الملف بنجاح');
}



}
