<?php

namespace App\Http\Requests\TrainingCreate;

use App\Enums\JobPositionEnum;
use Illuminate\Foundation\Http\FormRequest;

// StoreTrainingGoalsRequest.php
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
            
            'learning_outcomes' => 'required|array|min:2',
            'learning_outcomes.*' => 'required|string',

            'requirements' => 'nullable|array',
            'requirements.*' => 'required|string',
            'education_level_id'   => 'nullable|array',
            'education_level_id.*' => 'exists:education_levels,id',
            
            'work_sector_id'   => 'nullable|array',
            'work_sector_id.*' => 'exists:work_sectors,id',
            
            'job_position'   => 'nullable|array',
            'job_position.*' => 'string|in:' . implode(',', array_column(JobPositionEnum::cases(), 'value')),
            
            'country_id'   => 'nullable|array',
            'country_id.*' => 'exists:countries,id',
            
            'work_status'   => 'nullable|array',
            'work_status.*'=> 'nullable|string|in:working,not_working,not_specified,all', // لأنه عندك قيم نصية مش boolean
            


            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string',
        ];
    }

    public function messages(): array
{
    return [
        'learning_outcomes.required' => 'يجب تحديد النتائج التعليمية.',
        'learning_outcomes.array' => 'النتائج التعليمية يجب أن تكون مصفوفة.',
        'learning_outcomes.min' => 'يجب أن تحتوي النتائج التعليمية على الأقل على نتيجتين.',
        'learning_outcomes.*.required' => 'يجب تحديد نتيجة تعليمية واحدة على الأقل.',
        'learning_outcomes.*.string' => 'يجب أن تكون النتيجة التعليمية نصًا.',

        'requirements.array' => 'المتطلبات يجب أن تكون مصفوفة.',
        'requirements.*.required' => 'يجب تحديد متطلب.',
        'requirements.*.string' => 'يجب أن يكون المتطلب نصًا.',

        'education_level_id.array' => 'مستوى التعليم يجب أن يكون مصفوفة.',
        'education_level_id.*.exists' => 'مستوى التعليم المحدد غير موجود.',

        'work_sector_id.array' => 'قطاع العمل يجب أن يكون مصفوفة.',
        'work_sector_id.*.exists' => 'قطاع العمل المحدد غير موجود.',

        'job_position.array' => 'المسمى الوظيفي يجب أن يكون مصفوفة.',
        'job_position.*.string' => 'يجب أن يكون المسمى الوظيفي نصًا.',
        'job_position.*.in' => 'المسمى الوظيفي المحدد غير صحيح.',

        'country_id.array' => 'الدولة يجب أن تكون مصفوفة.',
        'country_id.*.exists' => 'الدولة المحددة غير موجودة.',

        'work_status.array' => 'حالة العمل يجب أن تكون مصفوفة.',
        'work_status.*.nullable' => 'يمكن أن تكون حالة العمل فارغة.',
        'work_status.*.string' => 'يجب أن تكون حالة العمل نصًا.',
        'work_status.*.in' => 'حالة العمل المحددة غير صحيحة.',

        'benefits.array' => 'الفوائد يجب أن تكون مصفوفة.',
        'benefits.*.nullable' => 'يمكن أن تكون الفائدة فارغة.',
        'benefits.*.string' => 'يجب أن تكون الفائدة نصًا.',
    ];
}
}