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
            // vendor_id لا يتم تحديثه لأنه دائماً ثابت
            'store_id' => 'sometimes|nullable|exists:stores,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0|max:1000000',
            'quantity' => 'sometimes|integer|min:0',
            'average_rating' => 'sometimes|integer|min:1|max:5',

            // Reel
            'reel' => 'sometimes|file|mimes:mp4,mov,avi,wmv|max:102400', // max 100MB

            // Images
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // max 10MB
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
            'store_id.exists' => 'المتجر المحدد غير موجود',
            'reel.max' => 'حجم الفيديو يجب ألا يتجاوز 100 ميجابايت',
            'reel.mimes' => 'صيغة الفيديو غير مدعومة',
            'images.*.max' => 'حجم كل صورة يجب ألا يتجاوز 10 ميجابايت',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'price.numeric' => 'السعر يجب أن يكون رقماً',
            'quantity.integer' => 'الكمية يجب أن تكون رقماً صحيحاً',
        ];
    }
}
