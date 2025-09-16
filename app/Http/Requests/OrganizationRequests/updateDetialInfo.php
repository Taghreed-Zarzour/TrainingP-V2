<?php

namespace App\Http\Requests\OrganizationRequests;

use Illuminate\Foundation\Http\FormRequest;

class updateDetialInfo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program_description' => 'nullable|string',
            'learning_outcomes' => 'nullable|array',
            'learning_outcomes.*' => 'requires|string',
            'program_type' => 'nullable|string|max:255',
            'language_id' => 'nullable|exists:languages,id',
            'classification' => 'nullable|array',
            'program_presentation_method' => 'nullable|string|max:255',
            'image' => 'nullable|file|image|max:2048',
            'assistant_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
{
    return [
        'program_description.string' => 'حقل وصف البرنامج يجب أن يكون نصاً.',

        'learning_outcomes.array' => 'حقل المخرجات التعليمية يجب أن يكون مصفوفة.',
        'learning_outcomes.*.string' => 'كل عنصر في المخرجات التعليمية يجب أن يكون نصاً.',

        'program_type.string' => 'حقل نوع البرنامج يجب أن يكون نصاً.',
        'program_type.max' => 'حقل نوع البرنامج يجب ألا يتجاوز 255 حرفاً.',

        'language_id.exists' => 'اللغة المحددة غير موجودة.',

        'classification.array' => 'حقل التصنيف يجب أن يكون مصفوفة.',

        'program_presentation_method.string' => 'طريقة تقديم البرنامج يجب أن تكون نصاً.',
        'program_presentation_method.max' => 'طريقة تقديم البرنامج يجب ألا تتجاوز 255 حرفاً.',

        'image.file' => 'يجب أن يكون الملف صورة صالحة.',
        'image.image' => 'الملف المرفوع يجب أن يكون صورة (jpg, png, jpeg ...).',
        'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',

        'assistant_id.exists' => 'المساعد المحدد غير موجود.',
    ];
}

}
