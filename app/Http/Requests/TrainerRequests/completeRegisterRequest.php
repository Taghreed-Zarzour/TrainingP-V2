<?php

namespace App\Http\Requests\TrainerRequests;

use App\Enums\SexEnum;
use App\Enums\TrainerStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ImportantTopicsType;

class completeRegisterRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  // protected function prepareForValidation()
  // {
  //     $topics = json_decode($this->important_topics, true) ?? [];

  //     // خذ فقط قيم value من كل عنصر
  //     $cleanedTopics = array_map(function ($item) {
  //         return is_array($item) && isset($item['value']) ? $item['value'] : $item;
  //     }, $topics);

  //     $this->merge([
  //         'important_topics' => $cleanedTopics,
  //     ]);
  // }

  public function rules(): array
  {
    return [
      'last_name_en' => 'nullable|string|max:255',
      'last_name_ar' => 'required|string|max:255',
      'sex' => ['required', new Enum(SexEnum::class)],
      'headline' => 'required|string|max:255',

      'nationality' => 'required|array|min:1',
      'nationality.*' => 'exists:countries,id',

      'international_exp' => 'sometimes|array|min:1',
      'international_exp.*' => 'exists:countries,id',

      'work_sectors' => 'required|array|min:1',
      'work_sectors.*' => 'exists:work_sectors,id',

      'provided_services' => 'required|array|min:1',
      'provided_services.*' => 'exists:provided_services,id',

      'work_fields' => 'required|array|min:1',
      'work_fields.*' => 'exists:work_fields,id',

      'important_topics' => 'required|array|min:1',
      'important_topics.*' => 'required',
      new Enum(ImportantTopicsType::class),

      'website' => 'sometimes|url',

      'linkedin_url' => 'sometimes|url',

      'hourly_wage' => 'nullable|numeric|min:0',

      'currency' => 'nullable|string',

      'name_en' => 'nullable|string|max:255',

      'name_ar' => 'required|string|max:255',

      'bio' => 'required|string|min:50|max:500',

      'country_id' => 'required|exists:countries,id',

      'city' => 'required|string',


      'phone_code' => ['required', 'regex:/^\+\d{1,4}$/'],
      'phone_number' => ['required', 'regex:/^\d{6,15}$/'],
    ];
  }

  public function messages(): array
  {
    return [
      'last_name_en.string' => 'يجب أن يكون الاسم الأخير باللغة الإنجليزية نصًا.',
      'last_name_en.max' => 'يجب ألا يتجاوز الاسم الأخير باللغة الإنجليزية 255 حرفًا.',

      'last_name_ar.required' => 'الاسم الأخير باللغة العربية مطلوب.',
      'last_name_ar.string' => 'يجب أن يكون الاسم الأخير باللغة العربية نصًا.',
      'last_name_ar.max' => 'يجب ألا يتجاوز الاسم الأخير باللغة العربية 255 حرفًا.',

      'sex.required' => 'الجنس مطلوب.',
      'sex.enum' => 'الجنس المحدد غير صالح.',

      'website.url' => 'يجب أن يكون الموقع الإلكتروني رابطًا صالحًا',

      'linkedin_url.url' => 'يجب أن يكون رابطًا صالحًا',

      'headline.required' => 'العنوان  مطلوب.',
      'headline.string' => 'يجب أن يكون العنوان نصًا.',
      'headline.max' => 'يجب ألا يتجاوز العنوان 255 حرفًا.',

      'nationality.required' => 'الجنسية مطلوبة.',
      'nationality.array' => 'يجب اختيار جنسية واحدة على الأقل.',
      'nationality.*.exists' => 'الجنسية المحددة غير صحيحة.',

      'work_sectors.required' => 'قطاعات العمل مطلوبة.',
      'work_sectors.array' => 'يجب اختيار قطاع عمل واحد على الأقل.',
      'work_sectors.*.exists' => 'قطاع العمل المحدد غير صحيح.',

      'provided_services.required' => 'الخدمات المقدمة مطلوبة.',
      'provided_services.array' => 'يجب اختيار خدمة واحدة على الأقل.',
      'provided_services.*.exists' => 'الخدمة المحددة غير صحيحة.',

      'work_fields.required' => 'مجالات العمل مطلوبة.',
      'work_fields.array' => 'يجب اختيار مجال واحد على الأقل.',
      'work_fields.*.exists' => 'مجال العمل المحدد غير صحيح.',

      'important_topics.required' => 'يجب إدخال المواضيع المهمة.',
      'important_topics.array' => 'يجب أن تكون المواضيع المهمة في شكل قائمة.',
      'important_topics.*.required' => 'كل موضوع مطلوب.',
      'important_topics.*.enum' => 'الموضوع المحدد غير صالح.',

      'international_exp.array' => 'يجب اختيار خبرة دولية واحدة على الأقل.',
      'international_exp.*.exists' => 'الخبرة الدولية المحددة غير صحيحة.',


      'hourly_wage.numeric' => 'يجب أن تكون الأجرة بالساعة رقمًا.',
      'hourly_wage.min' => 'يجب ألا تكون الأجرة بالساعة أقل من 0.',

      'currency.string' => 'يجب أن تكون العملة نصًا.',

      'name_en.string' => 'يجب أن يكون الاسم باللغة الإنجليزية نصًا.',
      'name_en.max' => 'يجب ألا يتجاوز الاسم باللغة الإنجليزية 255 حرفًا.',

      'name_ar.required' => 'الاسم باللغة العربية مطلوب.',
      'name_ar.string' => 'يجب أن يكون الاسم باللغة العربية نصًا.',
      'name_ar.max' => 'يجب ألا يتجاوز الاسم باللغة العربية 255 حرفًا.',

      'bio.required' => 'الوصف مطلوب.',
      'bio.string' => 'يجب أن يكون الوصف نصًا.',
      'bio.min' => 'يجب ألا تقل النبذة عن 50 أحرف',
      'bio.max' => 'يجب ألا تزيد النبذة عن 500 حرف',

      'country_id.required' => 'الدولة مطلوبة.',
      'country_id.exists' => 'الدولة المحددة غير صحيحة.',

      'city.required' => 'المدينة مطلوبة.',

      'phone_number.required' => 'حقل رقم الجوال مطلوب.',
      'phone_number.regex' => 'يجب أن يكون رقم الجوال مكونًا من 8 إلى 20 رقمًا، ويمكن أن يبدأ بعلامة "+" فقط.',

      'phone_code.required' => 'حقل رمز الدولة مطلوب.',
      'phone_code.regex' => 'يجب أن يكون رمز الدولة مكونًا من علامة + متبوعة بـ 1 إلى 4 أرقام.',

    ];
  }
}
