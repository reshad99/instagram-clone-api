<?php

namespace App\Http\Resources\V1\Status;

use App\Http\Resources\V1\User\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

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
        $data = [
            'id' => $this->id,
            'viewed' => $this->viewed,
            'customer' => new CustomerResource($this->customer),
            'stories' => StoryResource::collection($this->activeStories),
        ];

        // Check if the resource is a collection
        if ($this->resource instanceof Collection || $this->resource instanceof SupportCollection) {
            $data['count'] = $this->resource->count();
        }

        return $data;
    }
}
