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

'education_level_id'   => 'nullable|array',
'education_level_id.*' => 'exists:education_levels,id',

'work_sector_id'   => 'nullable|array',
'work_sector_id.*' => 'exists:work_sectors,id',

'job_position'   => 'nullable|array',
'job_position.*' => 'string|in:' . implode(',', array_column(JobPositionEnum::cases(), 'value')),

'country_id'   => 'nullable|array',
'country_id.*' => 'exists:countries,id',

'work_status'   => 'nullable|array',
'work_status.*'=> 'nullable|string|in:working,not_working', // لأنه عندك قيم نصية مش boolean

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


        // 'education_level_id.exists' => 'المستوى التعليمي المحدد غير موجود.',
        // 'work_status.boolean' => 'يجب أن يكون حالة العمل صحيحة أو خاطئة.',
        // 'work_sector_id.exists' => 'قطاع العمل المحدد غير موجود.',
        // 'job_position.in' => 'المسمى الوظيفي المحدد غير صالح.',
        // 'country_id.exists' => 'الدولة المحددة غير موجودة.',
    ];
}
}
