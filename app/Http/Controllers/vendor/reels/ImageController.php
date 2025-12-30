<?php

namespace App\Http\Controllers\vendor\reels;

use App\Http\Controllers\Controller;
use App\Http\Services\vendor\reels\ImageService;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageservice;
    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }
    public function storeNewImage(Product $product, $image, $number)
    {
        $this->imageservice->store($image, $product, $number);
        return true;
    }
    public function destroyImage(Image $image)
    {
        $this->imageservice->destroy($image);
        return true;
    }
}
