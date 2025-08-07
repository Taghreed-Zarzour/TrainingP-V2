<?php

namespace App\Http\Requests\TrainingAnnouncementRequests;

use Illuminate\Foundation\Http\FormRequest;

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

            'target_audience' => 'sometimes|array',
            'target_audience.*' => 'nullable|string'
            ,
            'learning_outcomes' => 'sometimes|array',
            'learning_outcomes.*' => 'nullable|string',

            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string',
            
            'payment_method' => 'nullable|string',
              'welcome_message' => ['nullable','string','max:1000',],
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
        
    ];
}
}
