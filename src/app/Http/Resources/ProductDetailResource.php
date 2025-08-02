<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->name,
            'price' => (float) $this->price,
            'image' => $this->featured_image,
            'description' => $this->description_en,
            'category' => $this->category->slug ?? 'uncategorized',
            'site_name' => $this->site_name ?? 'pro_travellers',
            'stock' => $this->quantity,
            'unit' => $this->unit,
            'discount' => $this->discount,
            'vat_percent' => $this->vat_percent,
            'is_sold_out' => (bool) $this->is_sold_out,
            'is_featured' => (bool) $this->is_featured,
            'slug' => $this->slug,
        ];
    }
}
