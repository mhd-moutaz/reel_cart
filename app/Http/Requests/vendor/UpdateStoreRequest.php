<?php

namespace App\Http\Requests\vendor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'store_name' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|max:2048',
            'address' => 'sometimes|string|max:500',
            'verification_docs' => 'sometimes|string|max:5120',
            'opening_hours' => 'sometimes|string|max:255',
        ];
    }
}
