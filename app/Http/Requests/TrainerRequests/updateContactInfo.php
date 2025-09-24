<?php

namespace App\Http\Requests\TrainerRequests;

use Illuminate\Foundation\Http\FormRequest;

class updateContactInfo extends FormRequest
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

            'country_id' => 'required|exists:countries,id',

            'city' => 'required|string',

            'phone_code' => ['required', 'regex:/^\+\d{1,4}$/'],
            'phone_number' => ['required', 'regex:/^\d{6,15}$/'],

            'website' => 'nullable|url',
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'الدولة مطلوبة.',
            'country_id.exists' => 'الدولة المحددة غير صحيحة.',

            'city.required' => 'المدينة مطلوبة.',
            'phone_code.required' => 'حقل رمز الدولة مطلوب.',
            'phone_code.regex' => 'يجب أن يكون رمز الدولة مكونًا من علامة + متبوعة بـ 1 إلى 4 أرقام.',

            'phone_number.required' => 'حقل رقم الجوال مطلوب.',
            'phone_number.regex' => 'يجب أن يكون رقم الجوال مكونًا من 6 إلى 15 رقماً دون أحرف أو رموز أخرى.',

            'website.url' => 'يجب أن يكون الموقع الإلكتروني رابطًا صالحًا',

        ];
    }
}
