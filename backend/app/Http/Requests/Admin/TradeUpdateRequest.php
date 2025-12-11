<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TradeUpdateRequest extends FormRequest
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
        $id = $this->trade->id;

        return [
            'name'        => "required|string|max:255|unique:trades,name,$id",
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ];
    }
}
