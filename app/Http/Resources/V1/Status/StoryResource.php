<?php

namespace App\Http\Resources\V1\Status;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
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
            'position' => $this->position,
            'status_id' => $this->status_id,
            'text' => $this->text,
            'media' => new MediaResource($this->media),
            'time' => $this->created_at->diffForHumans(),
            'viewed' => $this->viewed
        ];
    }
}
