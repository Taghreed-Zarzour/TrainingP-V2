<?php

namespace App\Http\Requests\TrainingCreate;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchedulingRequest extends FormRequest
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
        // إذا كان تم اختيار "تحديد الجلسات لاحقًا" لا نطبق القواعد على الجدول الزمني
        if ($this->input('schedules_later')) {
            return [
                'schedules_later' => 'required|boolean',
            ];
        }

        $rules = [
            'schedules_later' => 'sometimes|boolean',
            'schedules' => 'required|array|min:1',

            'schedules.*.session_date' => 'required|date|after_or_equal:today',
            'schedules.*.session_start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $endTime = $this->input("schedules.$index.session_end_time");
                    
                    if ($endTime && strtotime($value) >= strtotime($endTime)) {
                        $fail('وقت البدء يجب أن يكون قبل وقت الانتهاء.');
                    }
                },
            ],
            'schedules.*.session_end_time' => 'required|date_format:H:i',
        ];

        // إضافة قيد لتأكيد أن كل جلسة لاحقة تكون بعد الجلسة السابقة
        $schedules = $this->input('schedules', []);
        foreach ($schedules as $index => $schedule) {
            if ($index > 0) {
                $rules["schedules.$index.session_date"][] = function ($attribute, $value, $fail) use ($index, $schedules) {
                    $previousDate = $schedules[$index - 1]['session_date'] ?? null;
                    
                    if ($previousDate && strtotime($value) <= strtotime($previousDate)) {
                        $fail('تاريخ الجلسة الحالية يجب أن يكون بعد تاريخ الجلسة السابقة.');
                    }
                };
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'schedules_later.required' => 'حقل تحديد الجلسات لاحقًا مطلوب.',
            'schedules_later.boolean' => 'حقل تحديد الجلسات لاحقًا يجب أن يكون قيمة منطقية صحيحة.',
            
            'schedules.required' => 'يرجى إضافة جلسة تدريب واحدة على الأقل.',
            'schedules.array' => 'يجب أن تكون الجلسات بصيغة مصفوفة صحيحة.',
            'schedules.min' => 'يجب إدخال جلسة تدريب واحدة على الأقل.',

      

            'schedules.*.session_date.required' => 'يرجى تحديد تاريخ الجلسة.',
            'schedules.*.session_date.date' => 'تاريخ الجلسة غير صالح.',
            'schedules.*.session_date.after_or_equal' => 'يجب أن يكون تاريخ الجلسة اليوم أو أي تاريخ لاحق.',

            'schedules.*.session_start_time' => 'يرجى تحديد وقت بداية الجلسة.',
            'schedules.*.session_start_time.date_format' => 'تنسيق وقت البدء غير صحيح.',

            'schedules.*.session_end_time.required' => 'يرجى تحديد وقت نهاية الجلسة.',
            'schedules.*.session_end_time.date_format' => 'تنسيق وقت النهاية غير صحيح.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // إذا كان تم اختيار "تحديد الجلسات لاحقًا" نضمن أن schedules سيكون مصفوفة فارغة
        if ($this->input('schedules_later')) {
            $this->merge([
                'schedules' => [],
            ]);
        }
    }
}