<?php

namespace App\Http\Services\vendor;

use App\Models\Product;
use App\Models\Store;
use App\Models\Vendor;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function index($store){
        $product = Product::where('store_id',$store->id)->get();
        return $product;
    }
    public function show($product){
        return $product;
    }
    public function store(array $data){
        

    }
    public function update(){

    }
    public function destroy(){

    }
}
