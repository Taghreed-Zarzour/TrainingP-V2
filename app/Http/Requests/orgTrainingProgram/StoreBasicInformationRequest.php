<?php

namespace App\Http\Requests\orgTrainingProgram;

use App\Enums\programType;
use App\Enums\TrainingAttendanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreBasicInformationRequest extends FormRequest
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
            'title' => 'required|string',
            'language_id' => 'required|exists:languages,id',
            'country_id' => 'required|exists:countries,id',
            'city' => 'required',
            'address_in_detail' => 'required',
            'program_type' => ['required' , new Enum(programType::class)],
            'training_level_id' => 'required|exists:training_levels,id',
            'program_presentation_method' => ['required', new Enum(TrainingAttendanceType::class)],
            'org_training_classification_id' => 'required|array',
            'org_training_classification_id.*' => 'exists:training_classifications,id',
            'program_description' => 'required',
        ];
    }
    public function messages(): array
{
    return [
        'title.required' => 'عنوان البرنامج مطلوب.',
        'title.string' => 'يجب أن يكون عنوان البرنامج نصًا.',
        'language_type_id.required' => 'يجب اختيار نوع اللغة.',
        'language_type_id.exists' => 'نوع اللغة المحدد غير موجود.',
        'country_id.required' => 'يجب اختيار البلد.',
        'country_id.exists' => 'البلد المحدد غير موجود.',
        'city.required' => 'المدينة مطلوبة.',
        'address_in_detail.required' => 'العنوان بالتفصيل مطلوب.',
        'program_type.required' => 'نوع البرنامج مطلوب.',
        'program_type.enum' => 'نوع البرنامج غير صحيح.',
        'training_level_id.required' => 'يجب اختيار مستوى التدريب.',
        'training_level_id.exists' => 'مستوى التدريب المحدد غير موجود.',
        'program_presentation_method.required' => 'طريقة تقديم البرنامج مطلوبة.',
        'program_presentation_method.enum' => 'طريقة تقديم البرنامج غير صحيحة.',
        'org_training_classification_id.required' => 'تصنيف البرنامج مطلوب.',
        'org_training_classification_id.exists' => 'تصنيف البرنامج المحدد غير موجود.',
        'program_description.required' => 'وصف البرنامج مطلوب.',
    ];
}

}
