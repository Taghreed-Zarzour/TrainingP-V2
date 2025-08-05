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
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.exists' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'remember.boolean' => 'القيمة المحددة لتذكرني غير صحيحة.',
        ];
    }
}
