<?php

namespace App\Http\Controllers\vendor;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\vendor\StoreService;
use App\Http\Requests\vendor\StoreStoreRequest;

class StoreController extends Controller
{
    protected $storeService;
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function show(Store $store)
    {
        $store = $this->storeService->show($store);
        return response()->json($store, 200);
    }
    public function store(StoreStoreRequest $request)
    {
        $store=$this->storeService->store($request->validated());
        return response()->json($store, 201);
    }
    public function update(Request $request, Store $store)
    {
        
    }
}
