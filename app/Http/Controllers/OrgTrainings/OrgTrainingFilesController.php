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

        // Check if the file already exists in the storage
        if (Storage::disk('public')->exists($storagePath)) {
            return back()->with('error', 'الملف "' . $originalName . '" موجود مسبقًا في التخزين.');
        }

        // Check if the file exists in the database
        $existingFile = OrgTrainingDetailFile::where('training_files', $storagePath)
            ->where('org_training_program_id', $program_id)
            ->first();

        if ($existingFile) {
            // Update the existing record
            $existingFile->training_files = $storagePath;
            $existingFile->save();

            return back()->with('success', 'تم تحديث الملف "' . $originalName . '" بنجاح.');
        }

        // Store the new file
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
