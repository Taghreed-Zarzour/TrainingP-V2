<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class TrainingUpdateSessionService
{
public static function saveStep(string $id, string $step, array $data): void
{
    // إذا كان الخطوة 5، تأكد من حفظ جميع البيانات المهمة
    if ($step === 'step5') {
        // احصل على البيانات الحالية إذا كانت موجودة
        $currentData = self::getStep($id, $step);
        
        // تأكد من الحفاظ على جميع الحقول المهمة إذا لم يتم إرسالها جديدة
        $importantFields = [
            'is_free', 'cost', 'currency', 'payment_method', 'country_id', 
            'city', 'residential_address', 'application_deadline', 'max_trainees', 
            'application_submission_method', 'registration_link', 'profile_image', 'training_files'
        ];
        
        foreach ($importantFields as $field) {
            if (!isset($data[$field]) && isset($currentData[$field])) {
                $data[$field] = $currentData[$field];
            }
        }
        
        // معالجة الصورة التعريفية
        if (isset($data['profile_image'])) {
            // إذا الصورة جديدة مختلفة عن القديمة نحذف القديمة
            if (isset($currentData['profile_image']) && $currentData['profile_image'] !== $data['profile_image']) {
                Storage::disk('public')->delete($currentData['profile_image']);
            }
        }
        
        // معالجة ملفات التدريب
        if (isset($data['training_files'])) {
            // تأكد من أن training_files عبارة عن مصفوفة
            if (is_string($data['training_files'])) {
                $decoded = json_decode($data['training_files'], true);
                $data['training_files'] = is_array($decoded) ? $decoded : [];
            }
            
            // لو الملفات مختلفة أو جديدة نحذف القديمة
            if (isset($currentData['training_files'])) {
                $oldFiles = $currentData['training_files'];
                if (is_string($oldFiles)) {
                    $oldFiles = json_decode($oldFiles, true) ?? [];
                }
                
                $newFiles = $data['training_files'];
                
                // حذف الملفات القديمة غير الموجودة في الملفات الجديدة
                foreach ($oldFiles as $oldFile) {
                    if (!in_array($oldFile, $newFiles)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }
        }
    }
    
    // حفظ البيانات في السيشن
    session()->put("training_update.$id.$step", $data);
}
    public static function getStep(string $id, string $step): array
    {
        return session("training_update.$id.$step", []);
    }

    public static function getAll(string $id): array
    {
        return session("training_update.$id", []);
    }

    public static function clearAll(string $id): void
    {
        session()->forget("training_update.$id");
    }
}