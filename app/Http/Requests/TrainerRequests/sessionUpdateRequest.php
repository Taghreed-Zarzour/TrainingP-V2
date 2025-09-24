<?php

namespace App\Http\Requests\TrainerRequests;

use Illuminate\Foundation\Http\FormRequest;

class sessionUpdateRequest extends FormRequest
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
        
            'session_date' => 'required|date',
            'session_start_time' => 'required|date_format:H:i',
            'session_end_time' => 'required|date_format:H:i',
            'training_program_id' => 'sometimes|exists:training_programs,id'
        ];
    }

    public function messages(): array
    {
        return [
          
            'session_date.required' => 'تاريخ الجلسة مطلوب.',
            'session_date.date' => 'تاريخ الجلسة يجب أن يكون صيغة تاريخ صحيحة.',

            'session_start_time.required' => 'مدة بداية الجلسة مطلوبة.',

            'session_end_time.required' => 'مدة نهاية الجلسة مطلوبة.',
        ];
    }
}
