<?php

namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssistantsRequest extends FormRequest
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
            'assistant_ids' => 'required|array',
            'assistant_ids.*' => 'exists:users,id', // Ensure each ID exists in the users table
        ];
    }

    public function messages(): array
    {
        return [
            'assistant_ids.required' => 'يجب اختيار مساعد واحد على الأقل.',
            'assistant_ids.array' => 'يجب أن تكون المساعدات على شكل مصفوفة.',
            'assistant_ids.*.exists' => 'المساعد المحدد غير موجود في النظام.',
        ];
    }
}
