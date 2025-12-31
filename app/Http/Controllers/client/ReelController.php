<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Resources\vendor\ReelResource;
use App\Http\Services\client\ReelService;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    protected $reelService;
    public function __construct(ReelService $reelservice)
    {
        $this->reelService = $reelservice;
    }
    public function scrollReels()
    {
        $reels = $this->reelService->getAllReels();
        return $this->success(ReelResource::collection($reels), 201);
    }
}
