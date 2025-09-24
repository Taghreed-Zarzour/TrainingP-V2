<?php

namespace App\Http\Requests\TraineeRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\SexEnum;
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

      'name_en' => 'nullable|string|max:255',
      'name_ar' => 'required|string|max:255',

      'country_id' => 'required|exists:countries,id',

      'city' => 'required|string',

      'photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:5120',

    'phone_code' => ['required', 'regex:/^\+\d{1,4}$/'],
      'phone_number' => ['required', 'regex:/^\d{6,15}$/'],

    ];
  }

  public function messages(): array
  {
    return [
      'sex.enum' => 'الجنس المحدد غير صالح.',
      'country_id.required' => 'الدولة مطلوبة.',
      'country_id.exists' => 'الدولة المحددة غير صحيحة.',

      'city.required' => 'المدينة مطلوبة.',

      'last_name_en.string' => 'يجب أن يكون الاسم الأخير باللغة الإنجليزية نصًا.',
      'last_name_en.max' => 'يجب ألا يتجاوز الاسم الأخير باللغة الإنجليزية 255 حرفًا.',

      'last_name_ar.required' => 'الاسم الأخير باللغة العربية مطلوب.',
      'last_name_ar.string' => 'يجب أن يكون الاسم الأخير باللغة العربية نصًا.',
      'last_name_ar.max' => 'يجب ألا يتجاوز الاسم الأخير باللغة العربية 255 حرفًا.',

      'nationality.required' => 'الجنسية مطلوبة.',
      'nationality.array' => 'يجب اختيار جنسية واحدة على الأقل.',
      'nationality.*.exists' => 'الجنسية المحددة غير صحيحة.',

      'name_en.string' => 'يجب أن يكون الاسم باللغة الإنجليزية نصًا.',
      'name_en.max' => 'يجب ألا يتجاوز الاسم باللغة الإنجليزية 255 حرفًا.',

      'name_ar.required' => 'الاسم باللغة العربية مطلوب.',
      'name_ar.string' => 'يجب أن يكون الاسم باللغة العربية نصًا.',
      'name_ar.max' => 'يجب ألا يتجاوز الاسم باللغة العربية 255 حرفًا.',


      'photo.image' => 'الملف المرفق يجب أن يكون صورة.',
      'photo.mimes' => 'يجب أن تكون الصورة بصيغة JPG أو PNG.',
      'photo.max' => 'يجب ألا يتجاوز حجم الصورة 5 ميغابايت.',

    'phone_number.required' => 'حقل رقم الجوال مطلوب.',
      'phone_number.regex' => 'يجب أن يكون رقم الجوال مكونًا من 8 إلى 20 رقمًا، ويمكن أن يبدأ بعلامة "+" فقط.',

    ];
  }
}
