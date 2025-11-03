<?php

namespace App\Http\Services\vendor;

use App\Models\Store;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class StoreService
{
    public function show($store)
    {
        return $store;
    }
    public function store(array $data)
    {
        $data['vendor_id'] = Auth::id();
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('stores', 'public');
            $data['image'] = $imagePath;
        }
        $store = Store::create($data);
        return $store;
    }

    public function update(array $data,$store){
        if($store->vendor_id != Auth::id()){
            throw new \Exception('Unauthorized action.',403);
        }
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('stores', 'public');
            $data['image'] = $imagePath;
        }
        $store->update($data);
        return $store;
    }

}
