<?php

namespace App\Http\Requests\PreviousTrainingRequests;

use Illuminate\Foundation\Http\FormRequest;

class storePreviousTraining extends FormRequest
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
            'video_link'     => [
                'required',
                'url',
                'max:255',
                function ($attribute, $value, $fail) {
                    $watchableDomains = [
                        'youtube.com',
                        'youtu.be',
                        'vimeo.com',
                        'drive.google.com',
                        'dropbox.com',
                    ];

                    $host = parse_url($value, PHP_URL_HOST);

                    if (!$host || !collect($watchableDomains)->contains(fn($domain) => str_contains($host, $domain))) {
                        $fail('الرابط يجب أن يكون من YouTube أو Vimeo أو Google Drive أو Dropbox.');
                    }
                }
            ],
            'training_title'  => 'required|string|max:100',
            'description'    => 'required|string|max:1000',
        ];

    }

    public function messages(): array
    {
        return [
            'video_link.required'    => 'رابط الفيديو مطلوب.',
            'video_link.url'         => 'يجب أن يكون الرابط صالحًا (مثل YouTube أو Drive).',
            'video_link.max'         => 'يجب ألا يتجاوز الرابط 255 حرفًا.',
            'training_title.required' => 'عنوان التدريب مطلوب.',
            'training_title.max'      => 'يجب ألا يتجاوز العنوان 100 حرف.',
            'description.required'   => 'الوصف مطلوب.',
            'description.max'        => 'يجب ألا يتجاوز الوصف 1000 حرف.',
        ];
    }
}
