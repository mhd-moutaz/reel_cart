<?php

namespace App\Http\Resources\client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'client' => $this->client->user->name,
            'delivery' => $this->delivery_id,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'cart items'=>CartResource::collection($this->carts),
        ];
    }
}
