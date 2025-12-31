<?php

namespace App\Http\Requests\client;

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
            'birth_date' => 'required',
            'gender' => 'required|string|in:Male,Female',
            'address' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',
            'name.min' => 'Name must not be less than 2 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email is already taken',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.string' => 'Password must be a string',

            'phone_number.required' => 'Phone number is required',
            'phone_number.string' => 'Phone number must be a string',
            'phone_number.unique' => 'Phone number is already taken',

            'birth_date.required' => 'Birth date is required',

            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender must be either Male or Female',

            'address.required' => 'Address is required',
            'address.string' => 'Address must be a string',

            'image.image' => 'Image must be an image file',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg',
            'image.max' => 'Image must not exceed 2048 kilobytes',
        ];
    }
}
