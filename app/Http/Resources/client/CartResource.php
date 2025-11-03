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
            'order'=>[
                'id' => $this->order->id,
                'client_id' => $this->order->client->user->name,
                'delivery_id' => $this->order->delivery->user->name ?? null,
                'total_price' => $this->order->total_price,
                'status' => $this->order->status,
                'created_at' => $this->order->created_at,
                'updated_at' => $this->order->updated_at,
            ],
            'product'=>[
                'id' => $this->product->id,
                'name' => $this->product->name,
                'description' => $this->product->description,
                'price' => $this->product->price,
            ],
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'sub_total' => $this->sub_total,
        ];
    }
}
