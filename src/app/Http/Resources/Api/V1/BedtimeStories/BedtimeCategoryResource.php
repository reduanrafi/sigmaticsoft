<?php

namespace App\Http\Resources\Api\V1\BedtimeStories;

use Illuminate\Http\Resources\Json\JsonResource;

class BedtimeCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
        ];
    }
}
