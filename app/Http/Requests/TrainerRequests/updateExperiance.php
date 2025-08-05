<?php

namespace App\Http\Requests\TrainerRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ImportantTopicsType;
use Illuminate\Validation\Rules\Enum;

class updateExperiance extends FormRequest
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

            'work_sectors' => 'required|array|min:1',
            'work_sectors.*' => 'exists:work_sectors,id',

            'provided_services' => 'required|array|min:1',
            'provided_services.*' => 'exists:provided_services,id',

            'work_fields' => 'required|array|min:1',
            'work_fields.*' => 'exists:work_fields,id',

      'important_topics' => 'required|array|min:1',
      'important_topics.*' => 'required',
      new Enum(ImportantTopicsType::class),

            'international_exp' => 'required|array|min:1',
            'international_exp.*' => 'exists:countries,id',
        ];
    }

    public function messages(): array
    {
        return [
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



            'international_exp.required' => 'يجب إدخال خبرة دولية.',
            'international_exp.array' => 'يجب اختيار خبرة دولية واحدة على الأقل.',
            'international_exp.*.exists' => 'الخبرة الدولية المحددة غير صحيحة.',

        ];
    }
}
