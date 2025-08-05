<?php

namespace App\Http\Requests\TraineeRequests;

use App\Enums\TrainingAttendanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class updateProfessionalData extends FormRequest
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
            'job_position' =>['required', 'string', 'max:225'],
            'training_attendance' =>['required',new Enum(TrainingAttendanceType::class)],
            'work_institution' =>['nullable', 'string', 'max:225'],
            'fields_of_interest' => ['required','array','min:1'],
            'fields_of_interest.*' => ['string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'job_position.required' => 'الوظيفة مطلوبة.',
            'job_position.string' => 'الوظيفة يجب أن تكون نصًا.',
            'job_position.max' => 'الوظيفة يجب ألا تتجاوز 225 حرفًا.',

            'training_attendance.required' => 'نوع الحضور التدريبي مطلوب.',
            'training_attendance.enum' => 'نوع الحضور التدريبي غير صالح.',

            'work_institution.string' => 'اسم جهة العمل يجب أن يكون نصًا.',
            'work_institution.max' => 'اسم جهة العمل يجب ألا يتجاوز 225 حرفًا.',

            'fields_of_interest.required' => 'مجالات الاهتمام مطلوبة.',
            'fields_of_interest.array' => 'يجب تحديد مجالات الاهتمام على شكل قائمة.',
            'fields_of_interest.min' => 'يجب تحديد مجال اهتمام واحد على الأقل.',
            'fields_of_interest.*.string' => 'كل مجال اهتمام يجب أن يكون نصًا.',
            'fields_of_interest.*.max' => 'كل مجال اهتمام يجب ألا يتجاوز 255 حرفًا.',
        ];
    }
}
