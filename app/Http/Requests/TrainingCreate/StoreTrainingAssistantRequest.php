<?php

namespace App\Http\Requests\TrainingCreate;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingAssistantRequest extends FormRequest
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
            'trainer_ids' => 'nullable|array',
            'trainer_ids.*' => 'nullable|exists:users,id',

            'assistant_ids' => 'nullable|array',
            'assistant_ids.*' => 'nullable|exists:users,id',
        ];
    }
    public function messages(): array
{
    return [
        'trainer_ids.array' => 'قائمة المدربين يجب أن تكون مصفوفة.',
        'trainer_ids.*.required' => 'يرجى تحديد معرف المدرب.',
        'trainer_ids.*.exists' => 'المدرب المحدد غير موجود في قاعدة البيانات.',

        'assistant_ids.array' => 'قائمة المساعدين يجب أن تكون مصفوفة.',
        'assistant_ids.*.required' => 'يرجى تحديد معرف المساعد.',
        'assistant_ids.*.exists' => 'المساعد المحدد غير موجود في قاعدة البيانات.',
    ];
}
}
