<?php

namespace App\Http\Requests\TraineeRequests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerRatingRequest extends FormRequest
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
            'comment' => 'nullable|string|max:1000',
            'clarity' => 'required|integer|between:1,5',
            'interaction' => 'required|integer|between:1,5',
            'organization' => 'required|integer|between:1,5',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.max' => 'يجب ألا يتجاوز التعليق 1000 حرف.',
            'clarity.required' => 'يرجى تقييم الوضوح.',
            'clarity.integer' => 'قيمة الوضوح يجب أن تكون رقمًا صحيحًا.',
            'clarity.between' => 'تقييم الوضوح يجب أن يكون بين 1 و 5.',

            'interaction.required' => 'يرجى تقييم التفاعل.',
            'interaction.integer' => 'قيمة التفاعل يجب أن تكون رقمًا صحيحًا.',
            'interaction.between' => 'تقييم التفاعل يجب أن يكون بين 1 و 5.',

            'organization.required' => 'يرجى تقييم التنظيم.',
            'organization.integer' => 'قيمة التنظيم يجب أن تكون رقمًا صحيحًا.',
            'organization.between' => 'تقييم التنظيم يجب أن يكون بين 1 و 5.',
        ];
    }
}
