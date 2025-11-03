<?php

namespace App\Http\Controllers\vendor\store;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\vendor\store\StoreService;
use App\Http\Requests\vendor\StoreStoreRequest;
use App\Http\Requests\vendor\UpdateStoreRequest;
use App\Http\Resources\vendor\StoreResource;

class StoreController extends Controller
{
    protected $storeService;
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function show()
    {
        $store = $this->storeService->show();
        return $this->success(new StoreResource($store),200);
    }
    public function store(StoreStoreRequest $request)
    {
        $store=$this->storeService->store($request->validated());
        return $this->success(new StoreResource($store),201);
    }
    public function update(UpdateStoreRequest $request)
    {
        $store = $this->storeService->update($request->validated());
        return $this->success(new StoreResource($store),200);
    }
}
