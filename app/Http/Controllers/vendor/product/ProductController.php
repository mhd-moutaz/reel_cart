<?php

namespace App\Http\Controllers\vendor\product;


use App\Models\Reel;
use App\Models\Image;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\vendor\UpdateProductRequest;
use App\Http\Resources\vendor\ProductResource;
use App\Http\Requests\vendor\StoreProductRequest;
use App\Http\Services\vendor\product\ProductService;


class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(){
        $product = $this->productService->index();
        return $this->success( ProductResource::collection($product), 200);
    }
    public function show(Product $product){
        $product = $this->productService->show($product);
        return $this->success(new ProductResource($product), 200);
    }
    public function store(StoreProductRequest $request){
        $product = $this->productService->store($request->validated());
        return $this->success(new ProductResource($product), 201);
    }
    public function update(UpdateProductRequest $request, Product $product){
        $product = $this->productService->update($request->validated(), $product);
        return $this->success(new ProductResource($product), 200);

    }
    public function removeImage(Image $image)
    {
        $this->productService->removeImage($image);
        return $this->success([], 'Image removed successfully',200);
    }
    public function removeReel(Reel $reel)
    {
        $this->productService->removeReel($reel);
        return $this->success([], 'Reel removed successfully',200);
    }
    public function destroy(Product $product){
        $this->productService->destroy($product);
        return $this->success([], 'Product deleted successfully',200);

    }
}
