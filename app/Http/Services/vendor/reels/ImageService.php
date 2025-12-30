<?php

namespace App\Http\Services\vendor\reels;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Nullable;

use function PHPUnit\Framework\isNull;

class ImageService
{
    public function store($image, $product, $Number)
    {
        $imagePath = $image->storeAs('products',  'p' . $product->id . '.' . 'v' . $product->vendor_id . '.' . $Number . '.jpg', 'public');
        Image::create([
            'product_id' => $product->id,
            'image_url' => $imagePath,
        ]);
        return true;
    }
    public function destroy($image)
    {
        Storage::disk('public')->delete($image->image_url);
        $image->delete();
        return true;
    }
}
