<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'store_id' => 'sometimes|nullable|exists:stores,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0 ',
            'quantity' => 'sometimes|integer|min:0',
            'average_rating' => 'sometimes|integer|min:1|max:5',
            'reel' => 'sometimes|file|mimes:mp4,mov,avi,wmv|max:51200', // max 50MB
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'replace_images' => 'sometimes|boolean', // لاستبدال جميع الصور
            'delete_image_ids' => 'sometimes|array', // لحذف صور محددة
            'delete_image_ids.*' => 'integer|exists:images,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'store_id.exists' => 'The selected store does not exist',
            'reel.max' => 'The reel size must not exceed 50MB',
            'images.*.max' => 'Each image must not exceed 5MB',
        ];
    }
}
