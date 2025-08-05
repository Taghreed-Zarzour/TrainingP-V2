<?php

namespace App\Http\Requests\UserCvRequests;

use Illuminate\Foundation\Http\FormRequest;

class uploadCv extends FormRequest
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
            'uploadPdf' => 'required|file|mimes:pdf|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'uploadPdf.required' => 'حقل السيرة الذاتية مطلوب.',

            'uploadPdf.file' => 'يجب أن يكون الملف المرفوع ملفًا صالحًا.',

            'uploadPdf.mimes' => 'يجب أن يكون الملف من نوع PDF.',

            'uploadPdf.max' => 'يجب ألا يتجاوز حجم الملف 2 ميغابايت.',
        ];
    }
}
