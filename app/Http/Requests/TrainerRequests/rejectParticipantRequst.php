<?php

namespace App\Http\Requests\TrainerRequests;

use Illuminate\Foundation\Http\FormRequest;

class rejectParticipantRequst extends FormRequest
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
           'rejection_reason' => ['required','string','max:1000'],
        ];
    }

    public function messages(): array
{
    return [
        'rejection_reason.required' => 'يرجى إدخال سبب الرفض.',
        'rejection_reason.string'   => 'سبب الرفض يجب أن يكون نصًا.',
        'rejection_reason.max'      => 'سبب الرفض لا يمكن أن يتجاوز 1000 حرف.',
    ];
}

}
