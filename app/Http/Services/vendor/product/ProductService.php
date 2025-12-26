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

use function PHPUnit\Framework\isNull;

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
            if (Auth::check() && Auth::user()->vendor && Auth::user()->vendor->store) {
                $productData['store_id'] = Auth::user()->vendor->store->id;
                $productData['vendor_id'] = Auth::user()->vendor->id;
            } else {
                $productData['store_id'] = null;
                $productData['vendor_id'] = Auth::user()->vendor->id;
            }
            $product = Product::create($productData);
            $reelPath = $data['reel']->storeAs('reels', $product->id . '.' . $product->vendor_id . '.mp4', 'public');
            Reel::create([
                'video_url' => $reelPath,
                'product_id' => $product->id,
            ]);

            // حفظ الصور (اختياري)
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
            $product->load('reels', 'images', 'store');
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

            // تحضير البيانات للتحديث
            $productData = $data;
            unset($productData['images']);
            unset($productData['reel']);
            unset($productData['replace_images']);
            unset($productData['delete_image_ids']);

            // vendor_id دائماً موجود ولا يتغير
            // store_id اختياري ويمكن تحديثه
            if (isset($data['store_id'])) {
                $productData['store_id'] = $data['store_id'];
            }

            // تحديث بيانات المنتج الأساسية
            $product->update($productData);

            // تحديث الـ Reel إذا تم إرساله
            if (isset($data['reel'])) {
                // حذف الـ Reel القديم من التخزين
                $oldReel = $product->reels()->first();
                if ($oldReel && Storage::disk('public')->exists($oldReel->video_url)) {
                    Storage::disk('public')->delete($oldReel->video_url);
                }

                // رفع الـ Reel الجديد
                $reelPath = $data['reel']->storeAs(
                    'reels',
                    $product->id . '.' . $product->vendor_id . '.mp4',
                    'public'
                );

                // تحديث أو إنشاء الـ Reel في قاعدة البيانات
                if ($oldReel) {
                    $oldReel->update(['video_url' => $reelPath]);
                } else {
                    Reel::create([
                        'video_url' => $reelPath,
                        'product_id' => $product->id,
                    ]);
                }
            }

            // تحديث الصور إذا تم إرسالها
            if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
                // حذف الصور القديمة إذا كان replace_images = true
                if (isset($data['replace_images']) && $data['replace_images'] == true) {
                    foreach ($product->images as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage->image_url)) {
                            Storage::disk('public')->delete($oldImage->image_url);
                        }
                        $oldImage->delete();
                    }
                }

                // إضافة الصور الجديدة
                foreach ($data['images'] as $image) {
                    $imagePath = $image->store('products', 'public');
                    Image::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
                }
            }

            // حذف صور محددة إذا تم إرسال IDs
            if (isset($data['delete_image_ids']) && is_array($data['delete_image_ids'])) {
                $imagesToDelete = Image::whereIn('id', $data['delete_image_ids'])
                    ->where('product_id', $product->id)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    if (Storage::disk('public')->exists($image->image_url)) {
                        Storage::disk('public')->delete($image->image_url);
                    }
                    $image->delete();
                }
            }

            DB::commit();
            $product->save();
            $product->load('reels', 'images', 'store', 'vendor');
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update failed: ' . $e->getMessage());
            throw new GeneralException('Update product failed: ' . $e->getMessage());
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
