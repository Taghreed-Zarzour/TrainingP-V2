<?php

namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdditionalSettingsRequest extends FormRequest
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
        'cost' => 'nullable|numeric',
        'is_free' => 'nullable|boolean',
        'currency' => 'nullable|string|max:10',
        'payment_method' => 'nullable|string|max:255',
        'application_deadline' => 'required|date|after_or_equal:today',
        'max_trainees' => 'nullable|integer|min:0',
        'unlimited_trainees' => 'nullable|boolean',
        'application_submission_method' => 'required|in:inside_platform,outside_platform',
        'registration_link' => 'nullable|string|max:255',
        'requirements' => 'required|array|min:1',
        'requirements.*' => 'required|string|max:255',
        'benefits' => 'nullable|array',
        'benefits.*' => 'nullable|string|max:255',
        'training_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'welcome_message' => 'required|string',
    ];
}
public function messages(): array
    {
        return [
            'cost.numeric' => 'يجب أن تكون التكلفة رقمًا.',
            'currency.string' => 'يجب أن تكون العملة نصًا.',
            'currency.max' => 'لا يمكن أن تتجاوز العملة 10 أحرف.',
            'payment_method.string' => 'يجب أن تكون طريقة الدفع نصًا.',
            'payment_method.max' => 'لا يمكن أن تتجاوز طريقة الدفع 255 حرفًا.',
            'application_deadline.required' => 'يجب تحديد موعد انتهاء التقديم.',
            'application_deadline.date' => 'يجب أن يكون موعد انتهاء التقديم تاريخًا صحيحًا.',
            'max_trainees.required' => 'يجب تحديد الحد الأقصى للمتدربين.',
            'max_trainees.integer' => 'يجب أن يكون الحد الأقصى للمتدربين عددًا صحيحًا.',
            'max_trainees.min' => 'يجب أن يكون الحد الأقصى للمتدربين على الأقل 1.',
            'application_submission_method.required' => 'يجب تحديد طريقة تقديم الطلب.',
            'application_submission_method.in' => 'يجب أن تكون طريقة تقديم الطلب إما داخل المنصة أو خارجها.',
            'registration_link.string' => 'يجب أن يكون رابط التسجيل نصًا.',
            'registration_link.max' => 'لا يمكن أن يتجاوز رابط التسجيل 255 حرفًا.',
            // 'requirements.required' => 'يجب تحديد المتطلبات.',
            // 'requirements.string' => 'يجب أن تكون المتطلبات نصًا.',
            // 'benefits.required' => 'يجب تحديد الفوائد.',
            // 'benefits.string' => 'يجب أن تكون الفوائد نصًا.',
            'training_image.image' => 'يجب أن تكون صورة التدريب ملف صورة.',
            'training_image.mimes' => 'يجب أن تكون صورة التدريب من نوع: jpg, jpeg, png.',
            'training_image.max' => 'لا يمكن أن يتجاوز حجم صورة التدريب 2 ميغابايت.',
            'welcome_message.string' => 'يجب أن تكون الرسالة الترحيبية نصًا.',
        ];
    }
}
