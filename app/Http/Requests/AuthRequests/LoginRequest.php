<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required','email','exists:users,email'],
            'password' => ['required'],
            'remember' => 'nullable|boolean',
            // 'fcm_token' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'email.exists' => 'هذا البريد الإلكتروني غير موجود.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'remember.boolean' => 'يجب أن تكون قيمة التذكر صحيحة أو خاطئة.',
            'fcm_token.required' => 'رمز FCM مطلوب.',
            'fcm_token.string' => 'يجب أن يكون رمز FCM نصًا.',
        ];
    }
}
