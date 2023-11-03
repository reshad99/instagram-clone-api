<?php

namespace App\Http\Resources\V1\Status;

use App\Http\Resources\V1\User\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StatusResource extends JsonResource
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
            'id' => $this->id,
            'viewed' => $this->viewed,
            'count' => $this->count(),
            'customer' => new CustomerResource($this->customer),
            'stories' => StoryResource::collection($this->activeStories),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        if ($this->resource instanceof ResourceCollection) {
            return [
                'count' => $this->resource->count(),
            ];
        }

        return [];
    }
}
