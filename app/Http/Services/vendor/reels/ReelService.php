<?php

namespace App\Http\Services\vendor\reels;

use App\Models\Reel;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class ReelService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function store($reel, $product)
    {
        $reel = Reel::create([
            'product_id' => $product->id,
            'video_url' => $reel->storeAs('reels', $product->id . '.' . $product->vendor_id . '.mp4', 'public'),
        ]);
        return $reel;
    }
    public function update($reel, $product)
    {
        $oldreel = Reel::where('product_id', $product->id)->first();
        $this->destroy($oldreel);
        $reel = $this->store($reel, $product);
        return $reel;
    }
    public function destroy($reel)
    {
        Storage::disk('public')->delete($reel->video_url);
        $reel->delete();
        return true;
    }
}
