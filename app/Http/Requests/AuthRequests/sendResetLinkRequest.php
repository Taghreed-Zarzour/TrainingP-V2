<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class sendResetLinkRequest extends FormRequest
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
            'email' => ['required','email','exists:users,email']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'يرجى إدخال عنوان البريد الإلكتروني.',
            'email.email' => 'تأكد من أن البريد الإلكتروني مكتوب بشكل صحيح.',
            'email.exists' => 'لم نعثر على حساب مرتبط بهذا البريد الإلكتروني.',
        ];
    }

}
