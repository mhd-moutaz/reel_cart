<?php

namespace App\Http\Services\vendor\product;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Models\Reel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService
{
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

            $product = Product::create($productData);

            $reelPath = $data['reel']->storeAs('reels', $product->id . '.' . $product->vendor_id . '.mp4', 'public');
            Reel::create([
                'video_url' => $reelPath,
                'product_id' => $product->id,
            ]);

            if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
                foreach ($data['images'] as $image) {
                    $imagePath = $image->store('products', 'public');
                    Image::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
                }
            }

            DB::commit();
            $product->load('reels', 'images');
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

            // تحديث الـ Reel
            if (isset($data['reel']) && $data['reel']) {
                $oldReel = Reel::where('product_id', $product->id)->first();

                $newFileName = 'product_' . $product->id . '.mp4';
                $reelPath = $data['reel']->storeAs('reels', $product->id . '.' . $product->vendor_id . '.mp4', 'public');

                if ($oldReel) {
                    if (Storage::disk('public')->exists($oldReel->video_url)) {
                        Storage::disk('public')->delete($oldReel->video_url);
                    }

                    $affectedRows = DB::table('reels')
                        ->where('id', $oldReel->id)
                        ->update([
                            'video_url' => $reelPath,
                            'updated_at' => now()
                        ]);
                }

                if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {

                    if (isset($data['replace_images']) && $data['replace_images'] == true) {
                        foreach ($product->images as $oldImage) {
                            if (Storage::disk('public')->exists($oldImage->image_url)) {
                                Storage::disk('public')->delete($oldImage->image_url);
                            }
                            $oldImage->delete();
                        }
                    }

                    foreach ($data['images'] as $image) {
                        $imagePath = $image->storeAs('products',  $product->id . '.' . $product->vendor_id . '.jpg', 'public');
                        Image::create([
                            'product_id' => $product->id,
                            'image_url' => $imagePath,
                        ]);
                    }
                }

                DB::commit();
                $product->refresh();
                $product->load('reels', 'images', 'store', 'vendor');
            }

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
