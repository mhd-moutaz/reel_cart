<?php

namespace App\Http\Requests\vendor;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        'store_id' => 'required|exists:stores,id',
        'image_url' => 'required',
        'title' => 'required|string',
        'description' => 'required|string',
        'price' => 'required',
        'quantity' => 'required|integer',
        'average_rating' => 'required|integer|min:0|max:5',
        ];
    }
}
