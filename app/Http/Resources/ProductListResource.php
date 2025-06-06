<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'title' => $this->title,
            'weight' => $this->weight,
            'product_color' => $this->product_color,
            'image_url' => $this->image,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'published' => (boolean)$this->published,
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-md H:i:s'),

        ];
    }
}
