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

    public function index(){
        // return Auth::user()->vendor->store->products->reels;
        return Auth::user()->vendor->store->products()->with('reels')->get();

    }
    public function show($reel){
        if ($reel->store->vendor->id !== Auth::user()->vendor->id) {
            throw new GeneralException('unauthorized access to this reel', 403);
        }
        return $reel;
    }
    public function store(array $data){
        $product = Auth::user()->vendor->store->products->find($data['product_id']);
        if (!$product) {
            throw new GeneralException('unauthorized access to this product', 403);
        }
        $reel = Reel::create([
            'product_id' => $data['product_id'],
            'reel_url' => $data['reel_url']->store('reels', 'public'),
        ]);
        return $reel;
    }
    public function destroy($reel){
        if ($reel->product->store->vendor->id !== Auth::user()->vendor->id) {
            throw new GeneralException('unauthorized access to this reel', 403);
        }
        Storage::disk('public')->delete($reel->reel_url);
        $reel->delete();
        return true;
    }

}
