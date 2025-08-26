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
    // إذا كان تم اختيار "تحديد الجلسات لاحقًا" نتحقق من عدد الساعات والجلسات
    if ($this->input('schedules_later')) {
        return [
            'schedules_later' => 'required|boolean',
            'num_of_session' => 'required|integer|min:1',
            'num_of_hours' => 'required|numeric|min:0.5',
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
                $endTime = request("schedules.$index.session_end_time");
                if ($endTime && strtotime($value) >= strtotime($endTime)) {
                    $fail("وقت البدء يجب أن يكون قبل وقت الانتهاء.");
                }
            },
        ],
        'schedules.*.session_end_time' => 'required|date_format:H:i',
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
    
    // إضافة قيد لتأكيد أن تاريخ أول جلسة بعد تاريخ انتهاء التقديم
    $schedules = $this->input('schedules', []);
    if (!empty($schedules) && isset($schedules[0]) && $applicationDeadline) {
        $rules['schedules.0.session_date'][] = function ($attribute, $value, $fail) use ($applicationDeadline) {
            if (strtotime($value) <= strtotime($applicationDeadline)) {
                $fail('تاريخ أول جلسة يجب أن يكون بعد تاريخ انتهاء التقديم (' . date('Y-m-d', strtotime($applicationDeadline)) . ').');
            }
        };
    }
    
    // إضافة قيد لتأكيد أن كل جلسة لاحقة تكون بعد الجلسة السابقة
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
    
    return $rules;
}

public function messages(): array
{
    return [
        'schedules_later.required' => 'حقل تحديد الجلسات لاحقًا مطلوب.',
        'schedules_later.boolean' => 'حقل تحديد الجلسات لاحقًا يجب أن يكون قيمة منطقية صحيحة.',
        'num_of_session.required' => 'عدد الجلسات مطلوب عند تحديد الجلسات لاحقًا.',
        'num_of_session.integer' => 'عدد الجلسات يجب أن يكون رقمًا صحيحًا.',
        'num_of_session.min' => 'عدد الجلسات يجب أن يكون على الأقل 1.',
        'num_of_hours.required' => 'عدد الساعات مطلوب عند تحديد الجلسات لاحقًا.',
        'num_of_hours.numeric' => 'عدد الساعات يجب أن يكون رقمًا.',
        'num_of_hours.min' => 'عدد الساعات يجب أن يكون على الأقل 0.5.',
        
        'schedules.required' => 'يرجى إضافة جلسة تدريب واحدة على الأقل.',
        'schedules.array' => 'يجب أن تكون الجلسات بصيغة مصفوفة صحيحة.',
        'schedules.min' => 'يجب إدخال جلسة تدريب واحدة على الأقل.',
  
        'schedules.*.session_date.required' => 'يرجى تحديد تاريخ الجلسة.',
        'schedules.*.session_date.date' => 'تاريخ الجلسة غير صالح.',
        'schedules.*.session_date.after_or_equal' => 'يجب أن يكون تاريخ الجلسة اليوم أو أي تاريخ لاحق.',
        'schedules.*.session_start_time.required' => 'يرجى تحديد وقت بداية الجلسة.',
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


  

