<?php

namespace App\Http\Requests\TrainingCreate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TrainingAttendanceType;
class StoreBasicInformationRequest extends FormRequest
{/**
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
      'title' => 'required|string',
      'description' => 'nullable|string',
      'program_type_id' => 'required|exists:program_types,id',
      'language_type_id' => 'required|exists:languages,id',
      'training_classification_id' => 'required|exists:training_classifications,id',
      'training_level_id' => 'required|exists:training_levels,id',
      'program_presentation_method_id' => ['required', new Enum(TrainingAttendanceType::class)],
    ];
  }
  public function messages(): array
  {
    return [
      'title.required' => 'حقل العنوان مطلوب.',
      'title.string' => 'يجب أن يكون العنوان نصاً.',
      'description.string' => 'يجب أن يكون الوصف نصاً.',
      'program_type_id.required' => 'يرجى اختيار نوع البرنامج.',
      'program_type_id.exists' => 'نوع البرنامج المختار غير صالح.',
      'language_type_id.required' => 'يرجى اختيار اللغة.',
      'language_type_id.exists' => 'اللغة المختارة غير صالحة.',
      'training_classification_id.required' => 'يرجى اختيار تصنيف التدريب.',
      'training_classification_id.exists' => 'تصنيف التدريب غير صالح.',
      'training_level_id.required' => 'يرجى اختيار مستوى التدريب.',
      'training_level_id.exists' => 'مستوى التدريب غير صالح.',
      'program_presentation_method_id.required' => 'يرجى اختيار طريقة العرض.',
    ];
  }
}