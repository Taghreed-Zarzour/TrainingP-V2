<?php

namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;


class StoreSchedulingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
  public function rules()
{
    return [
        'program_title' => 'required|array',
        'program_title.*' => 'required|string|max:255',
        'schedules' => 'nullable|array',
        'schedules.*.date' => 'nullable|date_format:Y-m-d',
        'schedules.*.start_time' => 'nullable|date_format:H:i',
        'schedules.*.end_time' => [
            'nullable',
            'date_format:H:i',
            function ($attribute, $value, $fail) {
                $startTime = $this->input(str_replace('end_time', 'start_time', $attribute));
                if ($value && $startTime && $value <= $startTime) {
                    $fail('وقت الانتهاء يجب أن يكون بعد وقت البداية');
                }
            }
        ],
        'trainer_id' => 'nullable|array',
        'trainer_id.*' => 'exists:users,id',
        'training_files' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'schedules.*.schedules_later' => 'boolean',
    ];
}
// protected function prepareForValidation()
//     {
//         // Log the incoming request data
//         Log::info('Form Data Submitted:', $this->all());
//     }

public function messages()
{
    return [
        'program_title.required' => 'عنوان البرنامج مطلوب.',
        'program_title.array' => 'يجب أن يكون عنوان البرنامج مصفوفة.',
        'program_title.*.required' => 'كل عنوان برنامج مطلوب.',
        'program_title.*.string' => 'يجب أن يكون عنوان البرنامج نصًا.',
        'program_title.*.max' => 'عنوان البرنامج لا يمكن أن يتجاوز 255 حرفًا.',
        
        'schedules.array' => 'يجب أن يكون الجدول مصفوفة.',
        
        'schedules.*.date.required' => 'تاريخ الجلسة مطلوب.',
        'schedules.*.date.date_format' => 'تاريخ الجلسة يجب أن يكون بتنسيق Y-m-d.',
        
        'schedules.*.start_time.required' => 'وقت بدء الجلسة مطلوب.',
        'schedules.*.start_time.string' => 'وقت بدء الجلسة يجب أن يكون نصًا.',
        'schedules.*.start_time.date_format' => 'وقت بدء الجلسة يجب أن يكون بتنسيق H:i.',
        
        'schedules.*.end_time.required' => 'وقت انتهاء الجلسة مطلوب.',
        'schedules.*.end_time.string' => 'وقت انتهاء الجلسة يجب أن يكون نصًا.',
        'schedules.*.end_time.date_format' => 'وقت انتهاء الجلسة يجب أن يكون بتنسيق H:i.',
        'schedules.*.end_time.after' => 'وقت انتهاء الجلسة يجب أن يكون بعد وقت بدء الجلسة.',
        
        'trainer_id.array' => 'يجب أن تكون معرفات المدربين مصفوفة.',
        'trainer_id.*.exists' => 'معرف المدرب غير موجود.',
        
        'training_files.file' => 'يجب أن يكون الملف ملفًا.',
        'training_files.mimes' => 'يجب أن يكون الملف من نوع: pdf، jpg، jpeg، png.',
        'training_files.max' => 'حجم الملف لا يمكن أن يتجاوز 2048 كيلوبايت.',
        
        'schedules_later.boolean' => 'يجب أن تكون القيمة صحيحة أو خاطئة.',
    ];
}
}
