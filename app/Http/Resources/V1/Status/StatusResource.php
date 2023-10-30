<?php

namespace App\Http\Resources\V1\Status;

use App\Http\Resources\V1\User\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'customer' => new CustomerResource($this->customer),
            'stories' => StoryResource::collection($this->activeStories),
        ];
    }
}
