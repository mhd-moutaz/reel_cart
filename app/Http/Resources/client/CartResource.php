<?php

namespace App\Http\Resources\client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'selected product' => [
                'id' => $this->product->id,
                'name' => $this->product->title,
                'description' => $this->product->description,
                'quantity' => $this->product->quantity,
            ],
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'sub_total' => $this->sub_total,
        ];
    }
}
