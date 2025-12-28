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

    public function store($reel, $product)
    {
        $reel = $this->reelService->store($reel, $product);
        return true;
    }
    public function update($reel, $product)
    {
        $reel = $this->reelService->update($reel, $product);
        return true;
    }

}
