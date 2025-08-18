<?php

namespace App\Http\Requests\Assistantrequests;

use Illuminate\Foundation\Http\FormRequest;

class updateExperienceAndEducation extends FormRequest
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

            'bio' => 'required|string|min:50|max:500',

            'years_of_experience' => 'required|integer|min:0',

            'provided_services' => 'required|array',
            'provided_services.*' => 'exists:provided_services,id',

            'experience_areas' => 'required|array',
            'experience_areas.*' => 'exists:experience_areas,id',

            'specialization' => 'required|string|max:255',

            'university' => 'required|string|max:255',

            'graduation_year' => 'required|date',

            'education_levels_id' => 'required|exists:education_levels,id',

        ];
    }

    public function messages(): array
  {
    return [
      'bio.string' => 'يجب أن يكون الوصف نصًا.',
        'bio.min' => 'يجب ألا تقل النبذة عن 50 أحرف',
        'bio.max' => 'يجب ألا تزيد النبذة عن 500 حرف',

      'years_of_experience.required' => 'عدد سنوات الخبرة مطلوب.',
      'years_of_experience.integer' => 'يجب أن يكون عدد سنوات الخبرة رقمًا صحيحًا.',
      'years_of_experience.min' => 'يجب ألا يكون عدد سنوات الخبرة أقل من 0.',

      'provided_services.required' => 'الخدمات المقدمة مطلوبة.',
      'provided_services.*.exists' => 'الخدمة المحددة غير صالحة.',

      'experience_areas.required' => 'مجال الخبرة مطلوب.',
      'experience_areas.*.exists' => 'مجال الخبرة المحدد غير صحيح.',

      'specialization.required' => 'التخصص مطلوب.',
      'specialization.string' => 'يجب أن يكون التخصص نصًا.',
      'specialization.max' => 'يجب ألا يتجاوز التخصص 255 حرفًا.',

      'university.required' => 'اسم الجامعة مطلوب.',
      'university.string' => 'يجب أن يكون اسم الجامعة نصًا.',
      'university.max' => 'يجب ألا يتجاوز اسم الجامعة 255 حرفًا.',

      'graduation_year.required' => 'سنة التخرج مطلوبة.',
      'graduation_year.date' => 'يجب أن تكون سنة التخرج تاريخًا صحيحًا.',

      'education_levels_id.required' => 'مستوى التعليم مطلوب.',
      'education_levels_id.exists' => 'مستوى التعليم المحدد غير صحيح.',

    ];
  }
}
