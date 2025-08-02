<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->name,
            'price' => (float) $this->price,
            'image' => $this->featured_image ?? '/placeholder.svg?height=300&width=300&text=' . urlencode($this->name),
            'description' => $this->description,
            'is_sold_out' => $this->is_sold_out,
            'category' => $this->category ?? 'travel-gear',
        ];
    }
}
