<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\vendor\StoreProductRequest;
use App\Http\Services\vendor\ProductService;
use App\Models\Product;
use App\Models\Store;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Store $store){
        $product = $this->productService->index($store);
        return response()->json($product, 200);
    }
    public function show(Product $product){
        $product = $this->productService->show($product);
        return response()->json($product, 200);
    }
    public function store(StoreProductRequest $request){
        $product = $this->productService->store($request->validated());
        return response()->json($product, 201);
    }
    public function update(){

    }
    public function destroy(){

    }
}
