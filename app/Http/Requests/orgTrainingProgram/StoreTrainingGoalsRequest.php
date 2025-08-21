<?php

namespace App\Http\Requests\orgTrainingProgram;

use App\Enums\JobPositionEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingGoalsRequest extends FormRequest
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
        'learning_outcomes' => 'required|array|min:4',
        'learning_outcomes.*' => 'required|string',

        'target_audience' => 'required|array|min:1',
        'target_audience.*' => 'required|string',

        'education_level_id' => 'nullable|exists:education_levels,id', 
        'work_status' => 'nullable|boolean', 
        'work_sector_id' => 'nullable|exists:work_sectors,id', 
        'job_position' => 'nullable|string|in:' . implode(',', array_column(JobPositionEnum::cases(), 'value')), // Ensure valid job position from enum
        'country_id' => 'nullable|exists:countries,id', 
    ];
}
public function messages(): array
{
    return [
        'learning_outcomes.required' => 'يجب إدخال نتائج التعلم.',
        'learning_outcomes.array' => 'يجب أن تكون نتائج التعلم مصفوفة.',
        'learning_outcomes.min' => 'يجب أن تحتوي نتائج التعلم على 4 عناصر على الأقل.',
        'learning_outcomes.*.required' => 'يجب إدخال كل نتيجة تعلم.',
        'learning_outcomes.*.string' => 'يجب أن تكون نتيجة التعلم نصاً.',

        'target_audience.required' => 'يجب إدخال الجمهور المستهدف.',
        'target_audience.array' => 'يجب أن يكون الجمهور المستهدف مصفوفة.',
        'target_audience.min' => 'يجب أن يحتوي الجمهور المستهدف على عنصر واحد على الأقل.',
        'target_audience.*.required' => 'يجب إدخال كل عنصر في الجمهور المستهدف.',
        'target_audience.*.string' => 'يجب أن يكون عنصر الجمهور المستهدف نصاً.',

        'education_level_id.exists' => 'المستوى التعليمي المحدد غير موجود.',
        'work_status.boolean' => 'يجب أن يكون حالة العمل صحيحة أو خاطئة.',
        'work_sector_id.exists' => 'قطاع العمل المحدد غير موجود.',
        'job_position.in' => 'المسمى الوظيفي المحدد غير صالح.',
        'country_id.exists' => 'الدولة المحددة غير موجودة.',
    ];
}
}
