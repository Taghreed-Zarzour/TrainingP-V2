<?php

namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules(): array
    {
        return [
            'program_title' => 'required|string|max:255',
            'schedules' => 'nullable|array',
            'schedules.*.session_date' => 'required|date',
            'schedules.*.session_start_time' => 'required|date_format:H:i',
            'schedules.*.session_end_time' => 'required|date_format:H:i|after:schedules.*.session_start_time',
            'trainer_id' => 'nullable|array',
            'trainer_id.*' => 'exists:users,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Adjust file types and size as needed
            'schedules_later' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'program_title.required' => 'عنوان البرنامج مطلوب.',
            'program_title.string' => 'عنوان البرنامج يجب أن يكون نصًا.',
            'program_title.max' => 'عنوان البرنامج لا يمكن أن يتجاوز 255 حرفًا.',
            
            'schedules.array' => 'يجب أن تكون الجداول على شكل مصفوفة.',
            'schedules.*.session_date.required' => 'تاريخ الجلسة مطلوب.',
            'schedules.*.session_date.date' => 'تاريخ الجلسة يجب أن يكون تاريخًا صحيحًا.',
            'schedules.*.session_start_time.required' => 'وقت بدء الجلسة مطلوب.',
            'schedules.*.session_start_time.date_format' => 'وقت بدء الجلسة يجب أن يكون بتنسيق HH:MM.',
            'schedules.*.session_end_time.required' => 'وقت انتهاء الجلسة مطلوب.',
            'schedules.*.session_end_time.date_format' => 'وقت انتهاء الجلسة يجب أن يكون بتنسيق HH:MM.',
            'schedules.*.session_end_time.after' => 'وقت انتهاء الجلسة يجب أن يكون بعد وقت بدء الجلسة.',
            
            'trainer_id.array' => 'يجب أن يكون المدربون على شكل مصفوفة.',
            'trainer_id.*.exists' => 'المدرب المحدد غير موجود في النظام.',
            
            'file.file' => 'يجب أن تكون الملف المحدد ملفًا.',
            'file.mimes' => 'يجب أن يكون نوع الملف: pdf, jpg, jpeg, png.',
            'file.max' => 'يجب ألا يتجاوز حجم الملف 2 ميجابايت.',
            
            'schedules_later.boolean' => 'يجب أن تكون القيمة صحيحة أو خاطئة.',
        ];
    }
}
