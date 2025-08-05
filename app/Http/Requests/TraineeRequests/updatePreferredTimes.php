<?php

namespace App\Http\Requests\TraineeRequests;

use Illuminate\Foundation\Http\FormRequest;

class updatePreferredTimes extends FormRequest
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
            'preferred_times' => ['required', 'array', 'min:2'],
        ];
    }

    public function messages(): array
  {
    return [
        'preferred_times.required' => 'يرجى تحديد الأوقات التي تناسبك.',
        'preferred_times.array' => 'يجب أن تكون الأوقات المدخلة على شكل قائمة.',
        'preferred_times.min' => 'يرجى اختيار وقتين على الأقل من الأوقات التي تناسبك.',
    ];
}

}
