<?php

namespace App\Http\Controllers\User\CompletionData;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCvRequests\deleteCvRequest;
use App\Http\Requests\UserCvRequests\uploadCv;
use App\Models\UserCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserCvController extends Controller
{

    public function uploadCv(uploadCv $request)
{
    $file = $request->file('uploadPdf');
    $originalName = $file->getClientOriginalName(); 
    $userId = Auth::id();
    $fileName = $userId . '_' . time() . '_' . $originalName;
    $path = $file->storeAs('cvs', $fileName, 'public');

    // Save to DB
    $cv = UserCv::updateOrCreate(
        ['user_id' => $userId],
        ['cv_file' => $path]
    );

    return redirect()->back()->with('success', 'تم رفع السيرة الذاتية بنجاح.');
}


public function deleteCv(deleteCvRequest $request)
{
    $userId = Auth::id();
    $cv = UserCv::where('user_id',$userId)->first();
    Storage::delete($cv->cv_file);
    $cv->delete();

    return redirect()->back()->with('success', 'تم حذف السيرة الذاتية بنجاح.');
}

public function download($userId)
{
    $cv = UserCv::where('user_id', $userId)->firstOrFail();

    $filePath = storage_path('app/public/' . $cv->cv_file);

    if (!file_exists($filePath)) {
        abort(404, 'CV file not found.');
    }

    $fileName = basename($cv->cv_file); 

    return response()->download($filePath, $fileName, [
        'Content-Type' => 'application/pdf',
    ]);
}

}
