<?php

namespace App\Http\Resources;

use App\Http\Resources\vendor\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'national_id' => $this->national_id,
            'business_type' => $this->business_type,
            'description' => $this->description,
            'has_store' => $this->has_store,
            'store' => $this->store->store_name,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
