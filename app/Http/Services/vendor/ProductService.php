<?php

namespace App\Http\Services\vendor;

use App\Models\Image;
use App\Models\Store;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function index($store)
    {
        $product = Product::where('store_id', $store->id)->get();
        return $product;
    }
    public function show($product)
    {
        return $product;
    }
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $productData = $data;
            unset($productData['image_url']); // إزالة الصور من بيانات المنتج
            $product = Product::create($productData);

            if (isset($data['image_url']) && is_array($data['images'])) {
                // $imagePath = $data['image_url']->store('products', 'public');
                //     Image::create([
                //         'product_id' => $product->id,
                //         'image_url' => $imagePath,
                //     ]);
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
            throw new \Exception('add product failed');
        }


    }
    public function update()
    {

    }
    public function destroy()
    {

    }
}
