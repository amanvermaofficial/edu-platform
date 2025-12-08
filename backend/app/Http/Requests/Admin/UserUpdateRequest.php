<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user')->id;
          return [
            'name'  => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email,' . $userId],
            'role'  => ['required', 'string', 'exists:roles,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'role.exists' => 'Selected role does not exist.',
        ];
    }
}
