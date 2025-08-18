<?php

use App\Http\Controllers\User\CompletionData\UserCvController;
use Illuminate\Support\Facades\Route;

 Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
     Route::get('/download-cv/{user}/admin', [UserCvController::class, 'download'])->name('admin.download.cv');
 });
