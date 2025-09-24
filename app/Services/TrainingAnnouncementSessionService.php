<?php

namespace App\Services;

class TrainingAnnouncementSessionService
{
  public static function saveStep(string $step, array $data): void
    {
        // معالجة خاصة للملفات
        if (in_array($step, ['step5'])) { // الخطوة التي تحتوي على الملفات
            $currentData = self::getStep($step);
            
            // الحفاظ على الملفات القديمة إذا لم يتم إرسال جديدة
            if (!isset($data['profile_image']) && isset($currentData['profile_image'])) {
                $data['profile_image'] = $currentData['profile_image'];
            }
            
            if (!isset($data['training_files']) && isset($currentData['training_files'])) {
                $data['training_files'] = $currentData['training_files'];
            }
        }
        
        session()->put("training_form.$step", $data);
    }

    public static function getStep(string $step): array
    {
        return session("training_form.$step", []);
    }

    public static function clearAll(): void
    {
        session()->forget("training_form");
    }

    public static function getAll(): array
    {
        return session('training_form', []);
    }
}
