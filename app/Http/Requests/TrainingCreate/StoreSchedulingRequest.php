<?php

namespace App\Http\Requests\TrainingCreate;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TrainingProgram;
use App\Models\AdditionalSetting;

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
        $rules = [
            'schedules_later' => 'sometimes|boolean',
            'num_of_hours' => 'nullable|numeric|min:0.5',
            'schedules' => 'nullable|array',
            'schedules.*.session_date' => 'required_with:schedules|date|after_or_equal:today',
            'schedules.*.session_start_time' => [
                'required_with:schedules',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $endTime = request("schedules.$index.session_end_time");
                    if ($endTime && strtotime($value) >= strtotime($endTime)) {
                        $fail("وقت البدء يجب أن يكون قبل وقت الانتهاء.");
                    }
                },
            ],
            'schedules.*.session_end_time' => 'required_with:schedules|date_format:H:i',
        ];

        // الحصول على معرف التدريب من المسار
        $trainingId = $this->route('trainingId');

        // الحصول على تاريخ انتهاء التقديم من قاعدة البيانات
        $applicationDeadline = null;
        if ($trainingId) {
            $training = TrainingProgram::find($trainingId);
            if ($training) {
                $additionalSetting = $training->AdditionalSetting()->first();
                if ($additionalSetting) {
                    $applicationDeadline = $additionalSetting->application_deadline;
                }
            }
        }

        // إضافة قيد لتأكيد أن تاريخ أول جلسة بعد تاريخ انتهاء التقديم (فقط إذا كانت هناك جلسات)
        $schedules = $this->input('schedules', []);
        if (!empty($schedules) && isset($schedules[0]) && $applicationDeadline) {
            $rules['schedules.0.session_date'][] = function ($attribute, $value, $fail) use ($applicationDeadline) {
                if (strtotime($value) <= strtotime($applicationDeadline)) {
                    $fail('تاريخ أول جلسة يجب أن يكون بعد تاريخ انتهاء التقديم (' . date('Y-m-d', strtotime($applicationDeadline)) . ').');
                }
            };
        }

        // إضافة قيد لتأكيد أن كل جلسة لاحقة تكون بعد الجلسة السابقة (فقط إذا كانت هناك جلسات)
        if (!empty($schedules)) {
            foreach ($schedules as $index => $schedule) {
                if ($index > 0) {
                    $rules["schedules.$index.session_date"][] = function ($attribute, $value, $fail) use ($index, $schedules) {
                        $previousDate = $schedules[$index - 1]['session_date'] ?? null;

                        if ($previousDate && strtotime($value) <= strtotime($previousDate)) {
                            $fail('تاريخ الجلسة يجب أن يكون بترتيب تصاعدي. الجلسة ' . ($index + 1) . ' يجب أن تكون بعد الجلسة ' . $index . '.');
                        }
                    };
                }
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'schedules_later.boolean' => 'حقل تحديد الجلسات لاحقًا يجب أن يكون قيمة منطقية صحيحة.',
            'num_of_hours.numeric' => 'عدد الساعات يجب أن يكون رقمًا.',
            'num_of_hours.min' => 'عدد الساعات يجب أن يكون على الأقل 0.5.',

            'schedules.array' => 'يجب أن تكون الجلسات بصيغة مصفوفة صحيحة.',

            'schedules.*.session_date.required_with' => 'يرجى تحديد تاريخ الجلسة.',
            'schedules.*.session_date.date' => 'تاريخ الجلسة غير صالح.',
            'schedules.*.session_date.after_or_equal' => 'يجب أن يكون تاريخ الجلسة اليوم أو أي تاريخ لاحق.',
            'schedules.*.session_start_time.required_with' => 'يرجى تحديد وقت بداية الجلسة.',
            'schedules.*.session_start_time.date_format' => 'تنسيق وقت البدء غير صحيح.',
            'schedules.*.session_end_time.required_with' => 'يرجى تحديد وقت نهاية الجلسة.',
            'schedules.*.session_end_time.date_format' => 'تنسيق وقت النهاية غير صحيح.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // تأكد من أن جميع أوقات البدء والنهاية بصيغة H:i فقط
        $schedules = $this->input('schedules', []);



        foreach ($schedules as $i => $schedule) {
            if (isset($schedule['session_start_time'])) {
                $schedules[$i]['session_start_time'] = date('H:i', strtotime($schedule['session_start_time']));
            }
            if (isset($schedule['session_end_time'])) {
                $schedules[$i]['session_end_time'] = date('H:i', strtotime($schedule['session_end_time']));
            }
        }

        $this->merge([
            'schedules' => $schedules
        ]);
    }
}
