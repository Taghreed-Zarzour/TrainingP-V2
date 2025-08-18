<?php

namespace App\Http\Requests\TrainerRequests;

use App\Enums\SexEnum;
use App\Enums\TrainerStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class updatePersonalInfo extends FormRequest
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
      'last_name_en' => 'nullable|string|max:255',
      'last_name_ar' => 'required|string|max:255',


      'nationality' => 'required|array|min:1',
      'nationality.*' => 'exists:countries,id',

      'hourly_wage' => 'sometimes|numeric|min:0',

      'name_en' => 'nullable|string|max:255',
      'name_ar' => 'required|string|max:255',

      'currency' => 'sometimes|string',

      'linkedin_url' => 'nullable|url',

      'photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:5120',

      'bio' => 'required|string|max:500',
        'headline' => 'required|string|max:255',
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


      'nationality.required' => 'الجنسية مطلوبة.',
      'nationality.array' => 'يجب اختيار جنسية واحدة على الأقل.',
      'nationality.*.exists' => 'الجنسية المحددة غير صحيحة.',


      'hourly_wage.numeric' => 'يجب أن تكون الأجرة بالساعة رقمًا.',
      'hourly_wage.min' => 'يجب ألا تكون الأجرة بالساعة أقل من 0.',

      'name_en.string' => 'يجب أن يكون الاسم باللغة الإنجليزية نصًا.',
      'name_en.max' => 'يجب ألا يتجاوز الاسم باللغة الإنجليزية 255 حرفًا.',

      'name_ar.required' => 'الاسم باللغة العربية مطلوب.',
      'name_ar.string' => 'يجب أن يكون الاسم باللغة العربية نصًا.',
      'name_ar.max' => 'يجب ألا يتجاوز الاسم باللغة العربية 255 حرفًا.',


      'currency.string' => 'حقل العملة يجب أن يكون نصًا صحيحًا.',

      'linkedin_url.url' => 'رابط لينكدإن يجب أن يكون عنوان URL صالحًا (يبدأ بـ http أو https).',

      'photo.image' => 'الملف المرفق يجب أن يكون صورة.',
      'photo.mimes' => 'يجب أن تكون الصورة بصيغة JPG أو PNG.',
      'photo.max' => 'يجب ألا يتجاوز حجم الصورة 5 ميغابايت.',

      'bio.required' => 'النبذة مطلوبة',
      'bio.min' => 'يجب ألا تقل النبذة عن 10 أحرف',
      'bio.max' => 'يجب ألا تزيد النبذة عن 500 حرف',

      'headline.required' => 'العنوان  مطلوب.',
      'headline.string' => 'يجب أن يكون العنوان نصًا.',
      'headline.max' => 'يجب ألا يتجاوز العنوان 255 حرفًا.',
    ];
  }
}
