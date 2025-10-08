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
        
        // Generate a unique filename to avoid conflicts
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $storagePath = 'training/files/' . $filename;

        // Check if the file already exists in the database for this program
        $existingFile = OrgTrainingDetailFile::where('org_training_program_id', $program_id)
            ->where('training_files', 'like', '%' . $originalName . '%')
            ->first();

        if ($existingFile) {
            return back()->with('error', 'الملف "' . $originalName . '" موجود مسبقًا لهذا البرنامج التدريبي.');
        }

        // Store the new file
        $path = $uploadedFile->storeAs('training/files', $filename, 'public');

        // Prepare file data as JSON (required by database constraint)
        $fileData = [
            'original_name' => $originalName,
            'stored_path' => $path,
            'filename' => $filename,
            'size' => $uploadedFile->getSize(),
            'mime_type' => $uploadedFile->getMimeType(),
            'uploaded_at' => now()->toISOString()
        ];

        // Create the database record
        try {
            OrgTrainingDetailFile::create([
                'org_training_program_id' => $program_id,
                'training_files' => json_encode($fileData),
            ]);
        } catch (\Exception $e) {
            // If database insert fails, delete the uploaded file
            Storage::disk('public')->delete($path);
            return back()->with('error', 'حدث خطأ أثناء حفظ الملف: ' . $e->getMessage());
        }
    }

    return back()->with('success', 'تم رفع الملفات بنجاح.');
}


  public function deleteOrgTrainingFile($id)
{
    try {
        $file = OrgTrainingDetailFile::findOrFail($id);

        // Parse the JSON data to get file information
        $fileData = json_decode($file->training_files, true);
        
        if ($fileData && isset($fileData['stored_path'])) {
            // Delete the physical file from storage
            if (Storage::disk('public')->exists($fileData['stored_path'])) {
                Storage::disk('public')->delete($fileData['stored_path']);
            }
        }

        // Delete the database record
        $file->delete();

        return back()->with('success', 'تم حذف الملف بنجاح');
    } catch (\Exception $e) {
        return back()->withErrors('حدث خطأ أثناء حذف الملف: ' . $e->getMessage());
    }
}



}
