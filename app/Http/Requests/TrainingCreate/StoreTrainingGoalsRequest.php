<?php

namespace App\Http\Requests\TrainingCreate;

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
            
            'learning_outcomes' => 'required|array|min:4',
            'learning_outcomes.*' => 'required|string',

            'requirements' => 'nullable|array',
            'requirements.*' => 'required|string',

            'target_audience' => 'nullable|array',
            'target_audience.*' => 'required|string',

            'benefits' => 'nullable|array',
            'benefits.*' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'learning_outcomes.required' => 'يرجى إدخال ما سيتعلمه المشاركون.',
            'learning_outcomes.min' => 'يجب إدخال ٤ عناصر على الأقل من أهداف التعلم.',
            'learning_outcomes.*.required' => 'كل هدف تعلم يجب أن يكون نصاً.',

            'requirements.*.required' => 'يرجى إدخال كل المتطلبات.',
            'target_audience.*.required' => 'يرجى إدخال جميع عناصر الجمهور المستهدف.',
            'benefits.*.required' => 'يرجى إدخال كل فوائد التدريب.',
        ];
    }
}