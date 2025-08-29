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
    if (!$request->hasFile('training_files')) {
        return back()->with('error', 'يرجى اختيار ملف للرفع.');
    }

    $files = $request->file('training_files');

    foreach ($files as $uploadedFile) {
        $originalName = $uploadedFile->getClientOriginalName();
        $storagePath = 'training/files/' . $originalName;

        // تحقق من وجود الملف في التخزين
        if (Storage::disk('public')->exists($storagePath)) {
            return back()->with('error', 'الملف "' . $originalName . '" موجود مسبقًا في التخزين.');
        }

        // تحقق من وجود الملف في قاعدة البيانات
        $existsInDatabase = OrgTrainingDetailFile::where('training_files', $storagePath)
            ->where('org_training_program_id', $program_id)
            ->exists();

        if ($existsInDatabase) {
            return back()->with('error', 'الملف "' . $originalName . '" مسجل مسبقًا في قاعدة البيانات.');
        }

        $path = $uploadedFile->storeAs('training/files', $originalName, 'public');

        OrgTrainingDetailFile::create([
            'org_training_program_id' => $program_id,
            'training_files' => $path,
        ]);
    }

    return back()->with('success', 'تم رفع الملفات بنجاح.');
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
