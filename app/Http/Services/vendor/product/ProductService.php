<?php

namespace App\Http\Services\vendor\product;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Http\Controllers\vendor\reels\ImageController;
use App\Http\Controllers\vendor\reels\ReelController;
use App\Models\Reel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $reelController, $imageController;
    public function __construct(ReelController $reelController, ImageController $imageController)
    {
        $this->reelController = $reelController;
        $this->imageController = $imageController;
    }
    public function index()
    {
        $products = Auth::user()->vendor->products;
        return $products;
    }

    public function show($product)
    {
        if ($product->vendor->id !== Auth::user()->vendor->id) {
            throw new GeneralException('unauthorized access to this product', 403);
        }
        return $product;
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $productData = $data;
            unset($productData['images']);
            unset($productData['reel']);

            $productData['vendor_id'] = Auth::user()->vendor->id;
            if (Auth::check() && Auth::user()->vendor && Auth::user()->vendor->store) {
                $productData['store_id'] = Auth::user()->vendor->store->id;
            } else {
                $productData['store_id'] = null;
            }

            //Product
            $product = Product::create($productData);

            //Category
            if (isset($data['categories']) && is_array($data['categories'])) {
                $product->categories()->attach($data['categories']);
            }

            //Reel
            $this->reelController->store($data['reel'], $product);

            //Images
            if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
                foreach ($data['images'] as $key => $image) {
                    $numberOfImages = $key + 1;
                    $this->imageController->storeNewImage($product, $image, $numberOfImages);
                }
            }

            DB::commit();
            $product->load('reels', 'images', 'categories');
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product creation failed: ' . $e->getMessage());
            throw new GeneralException('add product failed: ' . $e->getMessage());
        }
    }

    public function update(array $data, $productId)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($productId->id);
            $vendorId = Auth::user()->vendor->id;

            if ($product->vendor_id !== $vendorId) {
                throw new GeneralException('Unauthorized to update this product');
            }

            $productData = [];
            $allowedFields = ['store_id', 'title', 'description', 'price', 'quantity', 'average_rating'];

            foreach ($allowedFields as $field) {
                if (array_key_exists($field, $data)) {
                    $productData[$field] = $data[$field];
                }
            }

            if (!empty($productData)) {
                $product->update($productData);
            }
            if (isset($data['reel'])) {
                $this->reelController->update($data['reel'], $product);
            }


            if (isset($data['delete_image_ids']) && is_array($data['delete_image_ids'])) {
                foreach ($data['delete_image_ids'] as $oldImageid) {
                    $oldImage = Image::findOrFail($oldImageid);
                    if ($oldImage->product_id === $product->id) {
                        $this->imageController->destroyImage($oldImage);
                    } else {
                        throw new GeneralException("This image is not for this product");
                    }
                }
            }

            if (isset($data['categories']) && is_array($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $key => $image) {
                    $numberOfImages = $key;
                    $this->imageController->storeNewImage($product, $image, $numberOfImages);
                }
            }

            DB::commit();
            $product->refresh();
            $product->load('reels', 'images', 'store', 'vendor');

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new GeneralException('Update product failed: ' . $e->getMessage());
        }
    }

    public function changeStatus($product, $quantity)
    {
        if ($product->quantity < $quantity) {
            throw new GeneralException('The requested quantity is not available', 400);
        } else if ($product->quantity === $quantity) {
            $reel = Reel::where('product_id', $product->id)->first();
            $product->quantity = 0;
            $reel->status = false;
            $reel->save();
            $product->save();
        } else {
            $product->quantity -= $quantity;
            $product->save();
        }
        return true;
    }
    public function destroy($product)
    {
        try {
            if ($product->vendor_id !== Auth::user()->vendor->id) {
                throw new GeneralException('This product in not yours', 403);
            }
            $product->delete();
            return true;
        } catch (\Exception $e) {
            throw new GeneralException('remove product failed');
        }
    }
}
