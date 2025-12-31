<?php

namespace App\Http\Services\client;

use App\Models\Reel;
use Illuminate\Http\Request;

class ReelService
{
    public function getAllReels()
    {
        $reels = Reel::get();
        return $reels;
    }
}
