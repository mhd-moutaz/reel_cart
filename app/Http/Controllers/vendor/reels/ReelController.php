<?php

namespace App\Http\Controllers\vendor\reels;

use App\Models\Reel;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\vendor\ReelResource;
use App\Http\Requests\vendor\StoreReelRequest;
use App\Http\Services\vendor\reels\ReelService;

class ReelController extends Controller
{
    protected $reelService;
    public function __construct(ReelService $reelService)
    {
        $this->reelService = $reelService;
    }

    public function index()
    {
        $reels = $this->reelService->index();
        return $this->success(ReelResource::collection($reels),'Reels retrieved successfully',200);
    }
    public function show(Reel $reel)
    {
        $reel = $this->reelService->show($reel);
        return $this->success(new ReelResource($reel),'Reel retrieved successfully',200);
    }
    public function store(StoreReelRequest $request)
    {
        $reel = $this->reelService->store($request->validated());
        return $this->success(new ReelResource($reel),'Reel created successfully',201);
    }

    public function destroy(Reel $reel)
    {
        $this->reelService->destroy($reel);
        return $this->success([],'Reel deleted successfully',200);
    }

}
