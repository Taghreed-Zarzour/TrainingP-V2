<?php

namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingGoalsRequest extends FormRequest
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
            'learning_outcomes' => 'required|array|min:4',
            'learning_outcomes.*' => 'required|string',

            'target_audience' => 'required|array|min:1',
            'target_audience.*' => 'required|string',

        ];
    }
}
