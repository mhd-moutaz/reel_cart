<?php

namespace App\Http\Resources\vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'store_name' => $this->store_name,
            'image' => $this->image,
            'address' => $this->address,
            'verification_docs' => $this->verification_docs,
            'opening_hours' => $this->opening_hours,
            'is_verified' => $this->is_verified,
        ];
    }
}
