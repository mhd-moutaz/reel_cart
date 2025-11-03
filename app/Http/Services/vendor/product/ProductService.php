<?php

namespace App\Http\Services\vendor\product;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function index()
    {
        $products = Auth::user()->vendor->store->products;
        return $products;
    }
    public function show($product)
    {
        if ($product->store->vendor->id !== Auth::user()->vendor->id) {
            throw new GeneralException('unauthorized access to this product', 403);
        }
        return $product;
    }
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $productData = $data;
            unset($productData['image_url']); // إزالة الصور من بيانات المنتج
            $productData['store_id'] = Auth::user()->vendor->store->id;
            $product = Product::create($productData);
            if (isset($data['image_url']) && is_array($data['image_url'])) {
                foreach ($data['image_url'] as $image) {
                    $imagePath = $image->store('products', 'public');
                    Image::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
                }
            }
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new GeneralException('add product failed');
        }
    }
    public function update(array $data, $product)
    {
        DB::beginTransaction();
        try {
            $productData = $data;
            $productData['store_id'] = Auth::user()->vendor->store->id;
            if (isset($data['image_url']) && is_array($data['image_url'])) {
                unset($productData['image_url']); // إزالة الصور من بيانات المنتج
                foreach ($data['image_url'] as $image) {
                    $imagePath = $image->store('products', 'public');
                    Image::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
                }
            }
            $product->update($productData);
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new GeneralException('add product failed');
        }
    }
    public function removeImage($image)
    {
        try {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
            return true;
        } catch (\Exception $e) {

            throw new GeneralException('remove image failed');
        }
    }
    public function destroy($product)
    {
        try {
            $product->delete();
            return true;
        } catch (\Exception $e) {
            throw new GeneralException('remove product failed');
        }
    }
}
