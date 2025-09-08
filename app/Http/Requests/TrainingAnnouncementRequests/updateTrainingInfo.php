<?php

namespace App\Http\Requests\TrainingAnnouncementRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\JobPositionEnum;

class updateTrainingInfo extends FormRequest
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
           'description' => 'nullable|string',

            'requirements' => 'sometimes|array',
            'requirements.*' => 'nullable|string',

            
            'learning_outcomes' => 'sometimes|array',
            'learning_outcomes.*' => 'nullable|string',

            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string',
            
            'payment_method' => 'nullable|string',
            'welcome_message' => ['nullable','string','max:1000',],

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

        'payment_method.string' => 'طريقة الدفع يجب أن تكون نصاً.',
        'payment_method.max' => 'طريقة الدفع يجب ألا تتجاوز 255 حرفاً.',

        'description.string' => 'يجب أن يكون الوصف نصاً.',

        'learning_outcomes.min' => 'يجب إدخال 2 عناصر على الأقل من أهداف التعلم.',
        'learning_outcomes.*.required' => 'كل هدف تعلم يجب أن يكون نصاً.',

           'welcome_message.string' => 'الرسالة الترحيبية يجب أن تكون نصاً.',
        'welcome_message.max' => 'الرسالة الترحيبية يجب ألا تتجاوز 1000 حرف.',

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

        
    ];
}
}
