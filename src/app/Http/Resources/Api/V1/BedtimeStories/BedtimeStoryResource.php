<?php

namespace App\Http\Resources\Api\V1\BedtimeStories;

use Illuminate\Http\Resources\Json\JsonResource;

class BedtimeStoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'audio_url' => $this->audio_url,
            'age_group' => $this->age_group,
            'category' => new BedtimeCategoryResource($this->whenLoaded('category')),
            'category_id' => $this->category_id,
            'is_favorite' => $this->is_favorite ?? false, // We'll handle this in controller if needed
            'created_at' => $this->created_at,
        ];
    }
}
