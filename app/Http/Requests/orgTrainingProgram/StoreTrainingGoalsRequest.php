<?php

namespace App\Http\Requests\orgTrainingProgram;

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

        ];
    }
    public function messages()
{
    return [
        'learning_outcomes.required' => 'نتائج التعلم مطلوبة.',
        'learning_outcomes.array' => 'نتائج التعلم يجب أن تكون مصفوفة.',
        'learning_outcomes.min' => 'يجب أن تحتوي نتائج التعلم على الأقل على 4 عناصر.',
        'learning_outcomes.*.required' => 'يجب إدخال نتيجة تعلم لكل عنصر.',
        'learning_outcomes.*.string' => 'يجب أن تكون نتيجة التعلم نصًا.',
        
        'target_audience.required' => 'الجمهور المستهدف مطلوب.',
        'target_audience.array' => 'الجمهور المستهدف يجب أن يكون مصفوفة.',
        'target_audience.min' => 'يجب أن يحتوي الجمهور المستهدف على الأقل على عنصر واحد.',
        'target_audience.*.required' => 'يجب إدخال جمهور مستهدف لكل عنصر.',
        'target_audience.*.string' => 'يجب أن يكون الجمهور المستهدف نصًا.',
    ];
}
}
