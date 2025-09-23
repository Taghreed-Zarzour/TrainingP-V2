<?php

namespace App\Http\Requests\OrganizationRequests;

use Illuminate\Foundation\Http\FormRequest;

class addAssisstantRequest extends FormRequest
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
            'assistant_id' => ['required', 'exists:users,id']
        ];
    }
    public function messages(): array
{
    return [
        'assistant_id.required' => 'يرجى اختيار مساعد.',
        'assistant_id.exists' => 'المساعد المختار غير موجود في النظام.',
    ];
}
}
