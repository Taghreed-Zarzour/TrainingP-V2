<?php

namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;

class updateSchedulingRequest extends FormRequest
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
            'session_date' => ['required'],
            'session_start_time' =>  ['required'],
            'session_end_time' =>  ['required'],
        ];
    }
}
