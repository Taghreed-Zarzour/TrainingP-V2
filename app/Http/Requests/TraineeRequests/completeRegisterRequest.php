<?php

namespace App\Http\Requests\TraineeRequests;

use App\Enums\SexEnum;
use App\Enums\TrainingAttendanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Models\WorkField;
use App\Enums\JobPositionEnum;
class completeRegisterRequest extends FormRequest
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
        'name_ar' => ['required', 'string', 'max:255'],
        'last_name_ar' => ['required', 'string', 'max:255'],
        'country_id' => ['required', 'exists:countries,id'],
        'nationality' => 'required|array|min:1',
        'nationality.*' => 'exists:countries,id',
        'investment_value' => ['required'],
        
      'phone_code' => ['required', 'regex:/^\+\d{1,4}$/'],
      'phone_number' => ['required', 'regex:/^\d{6,15}$/'],
        'city' => 'required|string',
        'sex' => ['required', new Enum(SexEnum::class)],
      'work_fields' => ['required', 'array', 'min:1'],
        'work_fields.*' => [
            function($attribute, $value, $fail) {
                if ($value === 'other') return;
                if (!WorkField::where('id', $value)->exists()) {
                    $fail('حقل العمل المحدد غير صحيح');
                }
            }
        ],
        'extra_work_field' => ['nullable', 'string', 'max:255'], // جعل الحقل غير مطلوب بشكل افتراضي
        'education_levels_id' => ['required', 'exists:education_levels,id'],
        'training_attendance' => ['required', new Enum(TrainingAttendanceType::class)],
        'is_working' => ['required', 'boolean'],
        'fields_of_interest' => ['required', 'array', 'min:1'],
        'preferred_times' => ['required', 'array', 'min:2'],
    ];
 if (in_array('other', $this->input('work_fields', []))) {
        $rules['extra_work_field'] = ['required', 'string', 'max:255'];
    }

    if ($this->input('is_working') == 1) {
$rules['job_position'] = ['required', new Enum(JobPositionEnum::class)];
        $rules['work_sectors'] = ['required', 'exists:work_sectors,id'];
    }

    return $rules;
}
  public function messages(): array
  {
    return [


      'name_ar.required' => 'الاسم بالعربية مطلوب.',
      'name_ar.string' => 'الاسم بالعربية يجب أن يكون نصًا.',
      'name_ar.max' => 'الاسم بالعربية يجب ألا يزيد عن 255 حرفًا.',

      'last_name_ar.required' => 'اسم العائلة بالعربية مطلوب.',
      'last_name_ar.string' => 'اسم العائلة بالعربية يجب أن يكون نصًا.',
      'last_name_ar.max' => 'اسم العائلة بالعربية يجب ألا يزيد عن 255 حرفًا.',

      'country_id.required' => 'الدولة مطلوبة.',
      'country_id.exists' => 'الدولة المختارة غير صحيحة.',

      'nationality.required' => 'الجنسية مطلوبة.',
      'nationality.array' => 'يجب اختيار جنسية واحدة على الأقل.',
      'nationality.*.exists' => 'الجنسية المحددة غير صحيحة.',

      'sex.required' => 'الجنس مطلوب.',
      'sex.in' => 'يرجى اختيار الجنس بين ذكر أو أنثى.',

     'investment_value' => 'يرجى اختيار القيمة التي تريد استثمارها',


      'education_levels_id.required' => 'مستوى التعليم مطلوب.',
      'education_levels_id.exists' => 'مستوى التعليم المختار غير صحيح.',

      'city.required' => 'المدينة مطلوبة.',

      'work_sectors.required' => 'يجب اختيار القطاع الذي تعمل به',
      'work_sectors.exists' => 'القطاع المحدد غير صحيح.',

      'job_position.max' => 'يجب ألا يزيد المسمى الوظيفي عن 100 حرف.',
      'job_position.required_if' => 'يجب إدخال المسمى الوظيفي إذا كنت تعمل حالياً',
      'job_position.string' => 'يجب أن يكون المسمى الوظيفي نصاً',

      'training_attendance.required' => 'حقل نوع الحضور مطلوب.',
      'training_attendance.enum' => 'نوع الحضور يجب أن يكون أحد القيم التالية: اونلاين، حضوري، أو عن بعد.',

      'is_working.required' => 'يرجى تحديد ما إذا كنت تعمل حالياً.',
      'is_working.boolean' => 'قيمة الحقل هل تعمل يجب أن تكون صحيحة أو خاطئة فقط.',

      'fields_of_interest.required' => 'يجب إدخال مجالات الاهتمام.',
      'fields_of_interest.array' => 'يجب أن تكون مجالات الاهتمام مصفوفة  .',
      'fields_of_interest.*.string' => 'كل مجال يجب أن يكون نصاً.',
      'fields_of_interest.*.max' => 'لا يمكن أن يتجاوز أي مجال 255 حرفاً.',

      'preferred_times.required' => 'يرجى تحديد الأوقات التي تناسبك.',
      'preferred_times.array' => 'يجب أن تكون الأوقات المدخلة على شكل قائمة.',
      'preferred_times.min' => 'يرجى اختيار وقتين على الأقل من الأوقات التي تناسبك.',

        'work_fields.required' => 'يجب اختيار مجالات العمل',
        'work_fields.array' => 'يجب اختيار مجالات العمل بشكل صحيح',
        'work_fields.min' => 'يجب اختيار مجال عمل واحد على الأقل',
        'extra_work_field.required' => 'يجب إدخال مجال العمل الإضافي عند اختيار "أخرى"',
        'extra_work_field.string' => 'يجب أن يكون مجال العمل الإضافي نصاً',
        'extra_work_field.max' => 'يجب ألا يتجاوز مجال العمل الإضافي 255 حرفاً',
          'phone_number.required' => 'حقل رقم الجوال مطلوب.',
      'phone_number.regex' => 'يجب أن يكون رقم الجوال مكونًا من 8 إلى 20 رقمًا، ويمكن أن يبدأ بعلامة "+" فقط.',

          'phone_code.required' => 'حقل رمز الدولة مطلوب.',
      'phone_code.regex' => 'يجب أن يكون رمز الدولة مكونًا من علامة + متبوعة بـ 1 إلى 4 أرقام.',

    ];

  }
}

