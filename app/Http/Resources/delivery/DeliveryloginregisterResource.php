<?php

namespace App\Http\Resources\delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryloginregisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'birth_date' => $this->birth_date,
            'national_id' => $this->national_id,
            'address' => $this->address,
            'image' => $this->image
        ];
    }
}
