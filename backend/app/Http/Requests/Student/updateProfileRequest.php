<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class updateProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone' => 'nullable|string|regex:/^[6-9]\d{9}$/',
            'course_id' => 'required|exists:courses,id',
            'trade_id' => 'required|string|exists:trades,id',
            'gender' => 'required|in:male,female,other',
            'state' => "required|string|max:255",
        ];
    }
}
