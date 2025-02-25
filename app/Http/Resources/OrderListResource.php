<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'status' => $this->status,
            'total_price' => $this->total_price,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->grand_total,
            'user' => new UserResource($this->user),
            'customer' => [
                'id' => $this->user->id,
                'first_name' => $this->user->customer->first_name,
                'last_name' => $this->user->customer->last_name,
            ],
            'created_at' => (new \DateTime($this->created_at))->format('Y-md H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-md H:i:s'),

        ];
    }
}
