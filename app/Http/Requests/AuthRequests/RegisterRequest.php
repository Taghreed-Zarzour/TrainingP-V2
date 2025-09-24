<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        'email' => ['required', 'string','unique:users,email'],
        'password' => ['required', 'confirmed', 'min:8'],
        'user_type_id' => ['required', 'exists:user_types,id']
    ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.unique' => 'لقد قمت بتسجيل الدخول بهذا الايميل مسبقاً ',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصاً.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل.',
            'user_type_id.required' => 'نوع المستخدم مطلوب.',
            'user_type_id.exists' => 'نوع المستخدم المحدد غير موجود.',
        ];
    }
}
