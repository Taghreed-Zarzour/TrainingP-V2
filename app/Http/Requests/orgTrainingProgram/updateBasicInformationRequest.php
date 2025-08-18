<?php

namespace App\Http\Requests\orgTrainingProgram;

use App\Enums\programType;
use App\Enums\TrainingAttendanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class updateBasicInformationRequest extends FormRequest
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
            'title' => 'nullable|string',
            'language_type_id' => 'nullable|exists:languages,id',
            'country_id' => 'nullable|exists:countries,id',
            'city' => 'nullable',
            'address_in_detail' => 'nullable',
            'program_type' => ['nullable' , new Enum(programType::class)],
            'training_level_id' => 'nullable|exists:training_levels,id',
            'program_presentation_method' => ['nullable', new Enum(TrainingAttendanceType::class)],
            'org_training_classification_id' => ['nullable', 'array', 'exists:training_classifications,id'],
            'program_description' => 'nullable',
        ];
    }
    public function messages(): array
{
    return [
        'title.nullable' => 'عنوان البرنامج يمكن أن يكون فارغًا.',
        'title.string' => 'يجب أن يكون عنوان البرنامج نصًا.',
        'language_type_id.nullable' => 'يمكن أن يكون نوع اللغة فارغًا.',
        'language_type_id.exists' => 'نوع اللغة المحدد غير موجود.',
        'country_id.nullable' => 'يمكن أن يكون البلد فارغًا.',
        'country_id.exists' => 'البلد المحدد غير موجود.',
        'city.nullable' => 'يمكن أن تكون المدينة فارغة.',
        'address_in_detail.nullable' => 'يمكن أن يكون العنوان بالتفصيل فارغًا.',
        'program_type.nullable' => 'يمكن أن يكون نوع البرنامج فارغًا.',
        'program_type.enum' => 'نوع البرنامج غير صحيح.',
        'training_level_id.nullable' => 'يمكن أن يكون مستوى التدريب فارغًا.',
        'training_level_id.exists' => 'مستوى التدريب المحدد غير موجود.',
        'program_presentation_method.nullable' => 'يمكن أن تكون طريقة تقديم البرنامج فارغة.',
        'program_presentation_method.enum' => 'طريقة تقديم البرنامج غير صحيحة.',
        'org_training_classification_id.nullable' => 'يمكن أن تكون تصنيفات البرنامج فارغة.',
        'org_training_classification_id.array' => 'تصنيفات البرنامج يجب أن تكون مصفوفة.',
        'org_training_classification_id.exists' => 'تصنيف البرنامج المحدد غير موجود.',
        'program_description.nullable' => 'يمكن أن يكون وصف البرنامج فارغًا.',
    ];
}
}
