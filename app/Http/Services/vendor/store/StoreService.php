<?php

namespace App\Http\Services\vendor\store;

use App\Exceptions\GeneralException;
use App\Models\Store;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class StoreService
{
    public function show()
    {
        $vendor = Auth::user()->vendor;
        return $vendor->store;
    }
    public function store(array $data)
    {
        if (Auth::user()->vendor->store) {
            throw new GeneralException('Store already exists for this vendor.');
        }
        $data['vendor_id'] = Auth::id();
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('stores', 'public');
            $data['image'] = $imagePath;
        }
        $store = Store::create($data);
        return $store;
    }

    public function update(array $data){
        $store = Auth::user()->vendor->store;
        if (!$store) {
            throw new GeneralException('Store does not exist for this vendor.');
        }
        if (isset($data['image'])) {
            Storage::disk('public')->delete($store->image);
            $imagePath = $data['image']->store('stores', 'public');
            $data['image'] = $imagePath;
        }
        $store->update($data);
        return $store;
    }

}
