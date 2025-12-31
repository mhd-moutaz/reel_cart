<?php

namespace App\Http\Services\client;

use App\Models\Product;
use App\Models\Reel;
use Illuminate\Http\Request;

class ReelService
{
    public function getAllReels()
    {
        $products =Product::get();
        $products->load('reels','images','categories');
        return $products;
    }
}
