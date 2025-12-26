<?php

namespace App\Http\Resources\vendor;

use App\Http\Resources\ReelResource;
use Illuminate\Http\Request;
use App\Http\Resources\vendor\ReelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'store' => $this->store->store_name ?? "you dont have store",
            'vendor' => $this->vendor->user->name,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'average_rating' => $this->average_rating,
            'images' => ImageResource::collection($this->images),
            'reels' => ReelResource::collection($this->reels),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
