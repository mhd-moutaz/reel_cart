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

            'image_url' => 'required',
            // 'image_url' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:10000',
            // 'reel_url' => 'required|file|mimes:mp4,mov,avi,wmv|max:50000',
            'reel_url' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|decimal:0,1000000',
            'quantity' => 'required|integer',
            'average_rating' => 'required|integer|min:1|max:5',
        ];
    }
}
