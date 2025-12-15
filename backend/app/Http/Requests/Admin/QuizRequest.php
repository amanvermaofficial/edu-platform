<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
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
            'title'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'duration'       => 'nullable|integer|min:1',
            'total_marks'    => 'nullable|integer|min:1',
            'course_trade_ids' => 'required|array',
            'course_trade_ids.*' => 'exists:course_trade,id',
        ];;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Quiz name is required',
            'course_trade_ids.required' => 'Please select at least one Course–Trade mapping',
        ];
    }
}
