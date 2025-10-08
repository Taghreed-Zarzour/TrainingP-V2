<?php
namespace App\Http\Requests\TrainingCreate;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingAssistantRequest extends FormRequest
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
            'trainer_ids' => 'required|array',
            'trainer_ids.*' => 'required|exists:users,id',
            'assistant_ids' => 'nullable|array',
            'assistant_ids.*' => 'nullable|exists:users,id',
        ];
        
        // إذا كان المستخدم مدرب (غير مؤسسة)
        if (auth()->user()->userType?->type !== 'مؤسسة') {
            // للمدرب: يمكن اختيار مدرب مشارك واحد ومساعد واحد فقط
            $rules['trainer_ids'] = 'required|array|max:1';
            $rules['assistant_ids'] = 'nullable|array|max:1';
        }
        
        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'trainer_ids.required' => 'يجب اختيار مدرب واحد على الأقل.',
            'trainer_ids.array' => 'قائمة المدربين يجب أن تكون مصفوفة.',
            'trainer_ids.*.required' => 'يجب تحديد المدرب.',
            'trainer_ids.*.exists' => 'المدرب المحدد غير موجود في قاعدة البيانات.',
            'assistant_ids.array' => 'قائمة المساعدين يجب أن تكون مصفوفة.',
            'assistant_ids.*.exists' => 'المساعد المحدد غير موجود في قاعدة البيانات.',
        ];
        
        // إذا كان المستخدم مدرب (غير مؤسسة)
        if (auth()->user()->userType?->type !== 'مؤسسة') {
            $messages['trainer_ids.max'] = 'يمكنك اختيار مدرب مشارك واحد فقط.';
            $messages['assistant_ids.max'] = 'يمكنك اختيار مساعد واحد فقط.';
        }
        
        return $messages;
    }
}