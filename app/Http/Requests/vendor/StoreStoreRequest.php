<?php

namespace App\Http\Requests\vendor;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'store_name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'address' => 'required|string|max:500',
            'verification_docs' => 'nullable|string|max:5120',
            'opening_hours' => 'nullable|string|max:255',
        ];
    }
}
