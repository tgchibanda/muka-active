<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = false;

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
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image,
            'images' => $this->images,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'published' => (bool)$this->published,
            'categories' => $this->categories->map(fn($c) => $c->id),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),

        ];
    }
}
