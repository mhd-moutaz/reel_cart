<?php

namespace App\Http\Requests\vendor;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|unique:users,phone_number',
            'national_id' => 'required|string|min:11|max:11|unique:vendors,national_id',
            'business_type' => 'required|string',
            'description' => 'required|string',
            'has_store' => 'required|in:yes,no',
            'pickup_address' => 'required|string',
            'pickup_hours' => 'required|date_format:H:i',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.unique' => 'This phone number is already registered.',
            'national_id.required' => 'National ID is required.',
            'national_id.unique' => 'This National ID is already registered.',
            'national_id.min' => 'National ID must be exactly 11 characters.',
            'national_id.max' => 'National ID must be exactly 11 characters.',
            'business_type.required' => 'Business type is required.',
            'description.required' => 'Description is required.',
            'has_store.required' => 'Please specify if you have a store.',
            'has_store.in' => 'Has store must be either "yes" or "no".',
            'pickup_address.required' => 'Pickup address is required.',
            'pickup_hours.required' => 'Pickup hours are required.',
            'pickup_hours.date_format' => 'Pickup hours must be in the format HH:MM.',
        ];
    }
}
