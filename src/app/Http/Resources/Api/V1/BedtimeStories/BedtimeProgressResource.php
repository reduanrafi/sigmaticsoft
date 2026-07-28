<?php

namespace App\Http\Resources\Api\V1\BedtimeStories;

use Illuminate\Http\Resources\Json\JsonResource;

class BedtimeProgressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'story' => new BedtimeStoryResource($this->whenLoaded('story')),
            'story_id' => $this->story_id,
            'progress' => $this->progress,
            'updated_at' => $this->updated_at,
        ];
    }
}
